<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SecurionPay\SecurionPayGateway;

class SecurionPayController extends Controller
{
    public function ipn(Request $request, DepositController $controller, $order = null)
    {
        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $general = General::first();

        $prepareGateway = new SecurionPayGateway($data->gateway->gateway_key_two);
        $finalAmount = ceil($data->usd_amo);
        $request = array(
            'amount' => $finalAmount,
            'currency' => $general->currency,
            'card' => array(
                'number' => $request->card_number,
                'expMonth' => $request->expiry_month,
                'expYear' => $request->expiry_year
            )
        );

        try {

            $deposit = Deposit::where('trx',$track)->first();
            $charge = $prepareGateway->createCharge($request);
            
            if ($charge->getAmount() == $finalAmount && $charge->getCurrency() == $general->currency) {

                if($deposit instanceof Deposit){
                    return $controller->userDataUpdate($deposit);
                }
            } else {
                return redirect()->route('deposit.index')->with('alert', 'Something went wrong.');
            }

        }catch(\Exception $e) {
            return redirect()->route('deposit.index')->with('alert', $e->getMessage());
        }
    }
}
