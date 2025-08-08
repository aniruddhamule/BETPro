<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{

    public $mode = 'sandbox';
    public $paymentGateWay;

    public function __construct()
    {
        $gateWay = PaymentGateway::find(1);
        $this->paymentGateWay = $gateWay;
        config([
            'paypal.mode'     => $this->mode,
            'paypal.sandbox' => [
                'client_id'         => $gateWay->gateway_key_one,
                'client_secret'     => $gateWay->gateway_key_two,
                'app_id'            => $gateWay->gateway_key_three,
            ],
            'paypal.live' => [
                'client_id'         => $gateWay->gateway_key_one,
                'client_secret'     => $gateWay->gateway_key_two,
                'app_id'            => $gateWay->gateway_key_three,
            ]
        ]);
    }

    public function payment()
    {
        try {
            $track = Session::get('Track');
            $depositData = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $gnl = General::first();
            $provider = new PayPalClient;
            
            $credantital = [
                'mode'    => $this->mode,
                   $this->mode => [
                    'client_id'         => $depositData->gateway->gateway_key_one,
                    'client_secret'     => $depositData->gateway->gateway_key_two,
                    'app_id'            => $depositData->gateway->gateway_key_three,
                ],
                'payment_action' => 'Sale',
                'currency'       => 'USD',
                'billing_type'   => 'MerchantInitiatedBilling',
                'notify_url'     => '',
                'locale'         => '',
                'validate_ssl'   => true,
            ];
            $provider->setApiCredentials($credantital);
            $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment.success'),
                    "cancel_url" => route('paypal.payment.cancel'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => floatval($depositData['usd_amo'])
                        ]
                    ]
                ]
            ]);
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect()->route('deposit.index')->with('alert', 'Something went wrong.');
            }else{
                return redirect()->route('deposit.index')->with('alert', 'Something went wrong.');
            }
        }catch (\Exception $e){
            return redirect()->route('deposit.index')->with('alert', $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('deposit.index')->with('alert', 'Sorry you payment is canceled');
    }


    public function success(Request $request, DepositController $controller)
    {
        $provider = new PayPalClient;
        $credantital = [
            'mode'    => $this->mode,
               $this->mode => [
                'client_id'         => $this->paymentGateWay->gateway_key_one,
                'client_secret'     => $this->paymentGateWay->gateway_key_two,
                'app_id'            => $this->paymentGateWay->gateway_key_three,
            ],
            'payment_action' => 'Sale',
            'currency'       => 'USD',
            'billing_type'   => 'MerchantInitiatedBilling',
            'notify_url'     => '',
            'locale'         => '',
            'validate_ssl'   => true,
        ];
        $provider->setApiCredentials($credantital);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $deposit = Deposit::where('trx',Session::get('Track'))->first();
            return $controller->userDataUpdate($deposit);
        } else {
            return redirect()->route('deposit.index')->with('alert', $response['message'] ?? 'Something went wrong.');
        }
    }
}
