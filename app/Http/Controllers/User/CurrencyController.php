<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Currency;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function currencyAll()
    {
        $currencyAll = Currency::active()->searchable(['cur_text', 'name'])->paginate(getPaginate());
        $pageTitle   = 'Crypto Currency';
        return view('Template::user.currency.index', compact('pageTitle', 'currencyAll'));
    }

    public function currencySingle($id)
    {
        $currency  = Currency::active()->findOrFail($id);
        $pageTitle = 'Buy ' . $currency->name . ' Currency';
        return view('Template::user.currency.preview', compact('pageTitle', 'currency'));
    }

    public function currencyStore(Request $request, $id)
    {
        $request->validate([
            'crypto_amount' => 'required|numeric|gte:0',
        ]);
        $user     = auth()->user();
        $currency = Currency::active()->findOrFail($id);
        $wallet   = Wallet::where('user_id', $user->id)->where('currency_id', $id)->first();
        if (!$wallet) {
            $notify[] = ['error', 'Wallet not found'];
            return back()->withNotify($notify);
        }

        $paidAmount = $currency->selling_price_total * $request->crypto_amount;
        if ($paidAmount > $user->balance) {
            $notify[] = ['error', 'You do not have sufficient balance'];
            return back()->withNotify($notify);
        }

        $trx = getTrx();

        $user->balance -= $paidAmount;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $paidAmount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        $transaction->trx          = $trx;
        $transaction->details      = showAmount($paidAmount) . ' ' . gs('cur_text') . ' Debited For ' . $currency->name;
        $transaction->remark       = 'currency_buy';
        $transaction->save();

        $wallet->amount += $request->crypto_amount;
        $wallet->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->wallet_id    = $wallet->id;
        $transaction->amount       = $request->crypto_amount;
        $transaction->post_balance = $wallet->amount;
        $transaction->trx_type     = '+';
        $transaction->trx          = $trx;
        $transaction->details      = showAmount($request->amount) . ' ' . $currency->name . ' Purchased ';
        $transaction->remark       = 'currency_buy';
        $transaction->save();

        notify($user, 'CURRENCY_BUY', [
            'amount'       => showAmount($request->crypto_amount),
            'currency'     => $currency->cur_text,
            'price'        => showAmount(getAmount($currency->rate) * $request->crypto_amount, 8),
            'post_amount'  => showAmount($wallet->amount, 8),
            'post_balance' => showAmount($user->balance),
            'rate'         => showAmount($currency->rate),
            'trx'          => $trx,
        ]);

        $notify[] = ['success', $currency->name . ' purchased successfully'];
        return to_route('user.currency.all')->withNotify($notify);
    }

    public function walletAll()
    {
        $pageTitle = 'Wallets';
        $wallets = Wallet::where('user_id', auth()->id())
            ->whereHas('currency', function ($query) {
                $query->where('status', Status::ENABLE);
            })
            ->with(['currency' => function ($query) {
                $query->where('status', Status::ENABLE);
            }])
            ->paginate(getPaginate());

        return view('Template::user.currency.wallet', compact('pageTitle', 'wallets'));
    }

    public function walletSingle($id)
    {
        $user               = auth()->user();
        $wallet             = Wallet::where('user_id', $user->id)->with('currency')->findOrFail($id);
        $transactions       = Transaction::where('wallet_id', $id)->where('user_id', $user->id)->orderBy('id', 'desc')->with('currencyCode')->paginate(getPaginate());
        $totalPurchased     = Transaction::where('wallet_id', $id)->where('user_id', $user->id)->where('remark', 'wallet_add')->sum('amount');
        $withdrawalApproved = Withdrawal::where('wallet_id', $id)->where('user_id', $user->id)->approved()->sum('amount');
        $withdrawalPending  = Withdrawal::where('wallet_id', $id)->where('user_id', $user->id)->pending()->sum('amount');
        $withdrawalRejected = Withdrawal::where('wallet_id', $id)->where('user_id', $user->id)->rejected()->sum('amount');

        $pageTitle = $wallet->currency->name . ' Wallet';
        return view('Template::user.currency.wallet_preview', compact('pageTitle', 'wallet', 'transactions', 'totalPurchased', 'withdrawalApproved', 'withdrawalPending', 'withdrawalRejected'));
    }

    public function walletWithdraw(Request $request, $id)
    {
        $user   = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->with('currency')->findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);

        if ($request->amount > $wallet->amount) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw'];
            return back()->withNotify($notify);
        }

        $wallet->amount -= $request->amount;
        $wallet->save();

        $userData = [
            [
                "name"  => "Wallet Address",
                "type"  => "text",
                "value" => $request->wallet_address,
            ],
        ];

        $trx = getTrx();

        $withdraw                       = new Withdrawal();
        $withdraw->user_id              = $user->id;
        $withdraw->wallet_id            = $wallet->id;
        $withdraw->currency_id          = $wallet->currency_id;
        $withdraw->amount               = $request->amount;
        $withdraw->currency             = $wallet->currency->cur_text;
        $withdraw->rate                 = $wallet->currency->rate;
        $withdraw->charge               = 0;
        $withdraw->final_amount         = $request->amount;
        $withdraw->after_charge         = $request->amount;
        $withdraw->trx                  = $trx;
        $withdraw->status               = Status::PAYMENT_PENDING;
        $withdraw->withdraw_information = $userData;
        $withdraw->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->wallet_id    = $wallet->id;
        $transaction->amount       = $request->amount;
        $transaction->post_balance = $wallet->amount;
        $transaction->trx_type     = '-';
        $transaction->trx          = $trx;
        $transaction->details      = showAmount($request->amount, currencyFormat: false) . ' ' . $wallet->currency->name . ' Withdrawal to ' . $request->wallet_address;
        $transaction->remark       = 'wallet_withdraw';
        $transaction->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New wallet withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.data.details', $withdraw->id);
        $adminNotification->save();

        notify($user, 'WALLET_WITHDRAW', [
            'amount'      => showAmount($request->amount),
            'currency'    => $wallet->currency->cur_text,
            'price'       => showAmount(getAmount($wallet->currency->rate) * $request->amount),
            'post_amount' => showAmount($wallet->amount),
            'rate'        => showAmount($wallet->currency->rate),
            'trx'         => $trx,
        ]);

        $notify[] = ['success', ' Withdraw request sent successfully'];
        return back()->withNotify($notify);
    }
}
