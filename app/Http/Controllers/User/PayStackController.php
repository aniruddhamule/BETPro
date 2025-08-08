<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Session;
use Unicodeveloper\Paystack\Facades\Paystack;

class PayStackController extends Controller
{
    public function redirectToGateway()
    {
        try{
            $gateway = PaymentGateway::find(5);
            config([
                'paystack.publicKey'     => $gateway->gateway_key_one,
                'paystack.secretKey'     => $gateway->gateway_key_two,
                'paystack.paymentUrl'     => 'https://api.paystack.co',
                'paystack.merchantEmail'     => $gateway->gateway_key_three,
            ]);
            
            
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
             return redirect()->route('deposit.index')->with('alert', 'The paystack token has expired. Please refresh the page and try again.');
        }        
    }

    public function handleGatewayCallback(DepositController $controller)
    {
        $gateway = PaymentGateway::find(5);
        config([
            'paystack.publicKey'     => $gateway->gateway_key_one,
            'paystack.secretKey'     => $gateway->gateway_key_two,
            'paystack.paymentUrl'     => 'https://api.paystack.co',
            'paystack.merchantEmail'     => $gateway->gateway_key_three,
        ]);

        $paymentDetails = Paystack::getPaymentData();
        $track = Session::get('Track');
        $deposit = Deposit::where('trx',$track)->first();
        
        if (($paymentDetails['status'] == true) && ($paymentDetails['data']['status'] == 'success') ) {
            return $controller->userDataUpdate($deposit);
        }
        return redirect()->route('deposit.index')->with('alert', 'Something is wrong.');
    }
}
