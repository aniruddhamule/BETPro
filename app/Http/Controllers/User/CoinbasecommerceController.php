<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\General;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CoinbasecommerceController extends Controller
{
    public function prepareData()
    {
        $general = General::first();
        $gateWay = PaymentGateway::find(14);
        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $apiKey = $gateWay->gateway_key_one ?? '';
        
        $postParam = [
            'name' => optional($deposit->user)->name ?? @$general->web_name,
            'description' => "Pay to {$general->web_name} account",
            'local_price' => [
                'amount' => $deposit->usd_amo,
                'currency' => "USD"
            ],
            'metadata' => [
                'trx' => $deposit->trx
            ],
            'pricing_type' => "fixed_price",
            'redirect_url' => route('coinbasecommerce.ipn'),
            'cancel_url' => route('coinbasecommerce.failed')
        ];

        

        $url = 'https://api.commerce.coinbase.com/charges';
        $headers = [
            'Content-Type:application/json',
            'X-CC-Api-Key: ' . "$apiKey",
            'X-CC-Version: 2018-03-22'];
        $response = curlPostRequestWithHeaders($url, $headers, $postParam);
        $response = json_decode($response);
        
        if (@$response->error == '') {
            return redirect($response->data->hosted_url);
        } else {
            return redirect()->route('deposit.index')->with('alert', 'Unexpected Error! Please Try Again.');
        }
    }

    public function ipn(Request $request,DepositController $controller)
    {
        try{
            $gateWay = PaymentGateway::find(14);
            $track = Session::get('Track');
            $deposit = Deposit::where('trx', $track)->first();
            $sentSign = $request->header('X-Cc-Webhook-Signature');
            $sig = hash_hmac('sha256', $request, $gateWay->gateway_key_two);
            if ($sentSign == $sig) {
                if ($request->event->type == 'charge:confirmed' && $deposit->status == 0) {
                    if($deposit instanceof Deposit){
                        return $controller->userDataUpdate($deposit);
                    }
                }
            }
        }catch(\Exception $e){
            return redirect()->route('deposit.index')->with('alert', 'Something went wrong please try again latter.');
        }
    }

    public function failed(Request $request){
        return redirect()->route('deposit.index')->with('alert', 'Sorry you payment is canceled');
    }
}
