<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\Currency;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cron()
    {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', Status::YES);
        }
        $crons = $crons->get();
        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds($cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->target == 'all') {
            $notify[] = ['success', 'Cron executed successfully'];
            return back()->withNotify($notify);
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }

    public function cryptocurrency_api()
    {
        $general           = gs();
        $defaultCurrency   = $general->cur_text;
        $url               = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';

        $cryptos = Currency::active()->pluck('cur_text')->toArray();
        $cryptos = implode(',', $cryptos);

        $parameters = [
            'symbol'  => $cryptos,
            'convert' => $defaultCurrency,
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY:' . trim($general->crypto_currency_api),
        ];

        $qs      = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL
        $curl    = curl_init(); // Get cURL resource

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $request, // set the request URL
            CURLOPT_HTTPHEADER     => $headers, // set the headers
            CURLOPT_RETURNTRANSFER => 1, // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        curl_close($curl); // Close request
        $response = json_decode($response);

        if (!$response?->data) {
            echo 'error';
        }

        $coins = $response?->data ?? [];


        foreach ($coins as $key => $coin) {
            $currency = Currency::where('cur_text', $key)->first();
            if ($currency) {
                $currency->rate                    = $coin[0]->quote->$defaultCurrency->price;
                $currency->one_hour_change         = $coin[0]->quote->$defaultCurrency->percent_change_1h;
                $currency->twentyfour_hour_change  = $coin[0]->quote->$defaultCurrency->percent_change_24h;
                $currency->market_cap              = $coin[0]->quote->$defaultCurrency->market_cap;

                $currency->selling_price_total     = ($currency->rate * ($currency->selling_price / 100)) + $currency->rate;
                $currency->save();
            }
        }
    }
}
