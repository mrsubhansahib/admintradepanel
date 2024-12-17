<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class CryptocurrencyController extends Controller {
    public function index() {
        $pageTitle        = 'Crypto Currencies';
        $cryptocurrencies = Currency::searchable(['name', 'cur_text'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.cryptocurrency.index', compact('pageTitle', 'cryptocurrencies'));
    }

    public function status($id) {
        return Currency::changeStatus($id);
    }

    public function store(Request $request, $id = null) {
        $validationRule = $id ? 'nullable' : 'required';
        $request->validate([
            'name'          => 'required|string|unique:currencies,name,' . $id,
            'cur_sym'       => 'required|string|unique:currencies,cur_sym,' . $id,
            'cur_text'      => 'required|string|unique:currencies,cur_text,' . $id,
            'selling_price' => 'required|numeric|between:0,100',
            'image'         => [$validationRule, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'cur_sym.unique'  => 'The symbol has already been taken.',
            'cur_text.unique' => 'The code has already been taken.',
        ]);

        if ($id) {
            $currency     = Currency::findOrFail($id);
            $notification = 'Currency updated successfully';
        } else {
            $currency     = new Currency();
            $notification = 'Currency added successfully';
        }

        $currency->name          = $request->name;
        $currency->cur_sym       = $request->cur_sym;
        $currency->cur_text      = $request->cur_text;
        $currency->selling_price = $request->selling_price;

        if ($request->hasFile('image')) {
            try
            {
                $old             = $currency->image;
                $currency->image = fileUploader($request->image, getFilePath('cryptoCurrency'), getFileSize('cryptoCurrency'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your currency image'];
                return back()->withNotify($notify);
            }
        }

        $currency->save();

        if (!$id) {
            $users = User::all();
            $data  = [];
            foreach ($users as $user) {
                $data[] = [
                    'user_id'     => $user->id,
                    'currency_id' => $currency->id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
            if (!blank($data)) {
                Wallet::insert($data);
            }
        }

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function apiStore(Request $request) {
        $request->validate([
            'crypto_currency_api' => 'required|string',
        ]);

        $general                      = gs();
        $general->crypto_currency_api = $request->crypto_currency_api;
        $general->save();

        $notify[] = ['success', 'Api key updated successfully'];
        return back()->withNotify($notify);
    }
}
