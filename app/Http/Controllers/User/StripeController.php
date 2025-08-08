<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;

class StripeController extends Controller
{
    public function ipnstripe(Request $request, DepositController $controller)
    {
        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $cnts = round($data->usd_amo,2) * 100;
        $gatewayData = $data->gateway;;

        Stripe::setApiKey($gatewayData->gateway_key_one);
        try {
            $charge = Charge::create(array(
                "amount" => $cnts,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "item"
            ));
            if ($charge['status'] == 'succeeded') {
                return $controller->userDataUpdate($data);
            }
            return redirect()->route('deposit.index')->with('alert', __('Something went wrong, please try again.'));
        }catch(\Exception $e){
            return redirect()->route('deposit.index')->with('alert', $e->getMessage());
        }

    }
}
