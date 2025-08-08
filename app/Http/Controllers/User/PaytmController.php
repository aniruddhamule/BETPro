<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PaytmController extends Controller
{
    public function order(Request $request){

        $depositTable = Deposit::where('trx', request()->orderID)->first();
        $user = User::find($depositTable->user_id);
      
        config([
            'services.paytm-wallet.merchant_id'         => $depositTable->gateway->gateway_key_one,
            'services.paytm-wallet.merchant_key'        => $depositTable->gateway->gateway_key_two,
            'services.paytm-wallet.merchant_website'    => request()->getHttpHost(),
            'services.paytm-wallet.channel'             => 'WEB',
            'services.paytm-wallet.industry_type'       => 'Retail',
        ]);

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => request()->orderID,
          'user' => $user->name,
          'mobile_number' => $user->mobile,
          'email' => $user->email,
          'amount' => $depositTable->amount,
          'callback_url' => route('paytm.callback')
        ]);

        return $payment->receive();

    }

    public function paymentCallback(DepositController $controller){

        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId();
        if($transaction->isSuccessful()){
          $track = Session::get('Track');
          $deposit = Deposit::where('trx',$track)->first();
          if($deposit instanceof Deposit){
              return $controller->userDataUpdate($deposit);
          }

        }else if($transaction->isFailed()){
            return redirect()->route('deposit.index')->with('alert', 'Something went wrong please try again latter.');
        }
    }
}
