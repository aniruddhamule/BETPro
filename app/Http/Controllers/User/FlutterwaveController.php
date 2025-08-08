<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\General;
use App\Models\Deposit;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use Illuminate\Support\Facades\Session;

class FlutterwaveController extends Controller
{
    public function initialize()
    {
        $depositTable = Deposit::where('trx', request()->orderID)->first();
        $user = User::find($depositTable->user_id);
        $general = General::first();

        if(($depositTable instanceof Deposit) && ($user instanceof User)){

            config([
                'flutterwave.publicKey'     => $depositTable->gateway->gateway_key_one,
                'flutterwave.secretKey'     => $depositTable->gateway->gateway_key_two,
                'flutterwave.secretHash'     => $depositTable->gateway->gateway_key_three,
            ]);


            $reference = Flutterwave::generateReference();
            $data = [
                'payment_options' => 'card,banktransfer',
                'amount' => $depositTable->amount,
                'email' => $user->email,
                'tx_ref' => $reference,
                'currency' => "NGN",
                'redirect_url' => route('rave.callback'),
                'customer' => [
                    'email' => $user->email,
                    "phonenumber" => $user->mobile,
                    "name" => $user->name
                ],
                "customizations" => [
                    "title" => $general->web_name,
                    "description" => "Add Fund"
                ]
            ];
            $payment = Flutterwave::initializePayment($data);
            if ($payment['status'] !== 'success') {
                return redirect()->route('deposit.index')->with('alert', 'Something went wrong please try again latter.');
            }
            return redirect($payment['data']['link']);
        }
        return redirect()->route('deposit.index')->with('alert', $e->getMessage());   
    }

    public function callback(DepositController $controller)
    {
        try{
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);
            if(isset($data)){
                $track = Session::get('Track');
                $deposit = Deposit::where('trx',$track)->first();
                if($deposit instanceof Deposit){
                    return $controller->userDataUpdate($deposit);
                }
            }
        }catch(Exception $e){
            return redirect()->route('deposit.index')->with('alert', 'Something went wrong please try again latter.');
        }
    }
}
