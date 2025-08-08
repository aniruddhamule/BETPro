<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\PaymentGateway;
use App\Models\Deposit;
use Illuminate\Http\Request;
use CoinGate\CoinGate;
use CoinGate\Merchant\Order;
use Illuminate\Support\Facades\Session;

require_once('vendor/coingate/coingate-php/init.php');

class CoingateController extends Controller
{
    public function prepareData(DepositController $controller)
    {
        $general = General::first();
        $gateWay = PaymentGateway::find(13);
        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        CoinGate::config(array(
            'environment' => 'live', // sandbox OR live
            'auth_token' => $gateWay->gateway_key_one
        ));
        
        $postParams = array(
            'order_id' => $data->trx,
            'price_amount' => $data->usd_amo,
            'price_currency' => "USD",
            'callback_url' => route('coingate.ipn'),
            'cancel_url' => route('coingate.failed'),
            'success_url' => route('coingate.success'),
            'title' => "Payment To {$general->web_name} Account",
            'token' => $data->trx
        );

        $order = Order::create($postParams);

        if ($order) {
            return redirect($order->payment_url);
        } else {
            return redirect()->route('deposit.index')->with('alert', 'Unexpected Error! Please Try Again.');
        }
    }

    public function ipn(Request $request,DepositController $controller){
        try{
            $track = Session::get('Track');
            $deposit = Deposit::where('trx',$track)->first();
            $ip = $request->ip();
            
            $url = 'https://api.coingate.com/v2/ips-v4';
            $response = curlGetRequest($url);
            if (strpos($response, $ip) !== false) {
                if ($request->status == 'paid' && $request->price_amount == $deposit->usd_amo && $deposit->status == 0) {
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

    public function success(Request $request,DepositController $controller){
        try{
            $track = Session::get('Track');
            $deposit = Deposit::where('trx',$track)->first();
            $ip = $request->ip();
            $url = 'https://api.coingate.com/v2/ips-v4';
            $response = curlGetRequest($url);
            if (strpos($response, $ip) !== false) {
                if ($request->status == 'paid' && $request->price_amount == $deposit->usd_amo && $deposit->status == 0) {
                    if($deposit instanceof Deposit){
                        return $controller->userDataUpdate($deposit);
                    }
                }
            }
            return redirect()->route('deposit.index')->with('alert', 'Something went wrong please try again latter.');
        }catch(\Exception $e){
            return redirect()->route('deposit.index')->with('alert', 'Something went wrong please try again latter.');
        }
    }
}
