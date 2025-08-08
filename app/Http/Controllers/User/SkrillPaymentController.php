<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\General;
use App\Models\PaymentGateway;
use App\Models\User;
use Obydul\LaraSkrill\SkrillClient;
use Obydul\LaraSkrill\SkrillRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SkrillPaymentController extends Controller
{
    private $skrilRequest;

    public function __construct()
    {
        $gateway = PaymentGateway::find(8);
        $this->skrilRequest = new SkrillRequest();
        $this->skrilRequest->pay_to_email = $gateway->gateway_key_one;
        $this->skrilRequest->return_url = route('skrill.payment.complete');
        $this->skrilRequest->cancel_url = round('skrill.payment.cancelled');
        $this->skrilRequest->logo_url = asset('images/logo/logo.png');
        $this->skrilRequest->status_url = route('skrill.ipn');
        $this->skrilRequest->status_url2 = route('skrill.ipn');
    }

    public function makePayment()
    {
        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $user =  User::find($data->user_id);
        $gnl = General::first();
        
        $this->skrilRequest->transaction_id = $track;
        $this->skrilRequest->amount = $data->usd_amo;
        $this->skrilRequest->currency = 'USD';
        $this->skrilRequest->language = 'EN';
        $this->skrilRequest->prepare_only = '1';
        $this->skrilRequest->merchant_fields = $gnl->web_name.' , '.$user->email;
        $this->skrilRequest->site_name = $gnl->web_name;
        $this->skrilRequest->customer_email = $user->email;
        $this->skrilRequest->detail1_description = 'Add Balance';
        $this->skrilRequest->detail1_text = '101';

        $client = new SkrillClient($this->skrilRequest);
        $sid = $client->generateSID();

        $jsonSID = json_decode($sid);
        if ($jsonSID != null && $jsonSID->code == "BAD_REQUEST")
            return $jsonSID->message;

        $redirectUrl = $client->paymentRedirectUrl($sid);
        return Redirect::to($redirectUrl);
    }

    public function ipn(Request $request)
    {
        $transaction_id = $request->transaction_id;
        $mb_transaction_id = $request->mb_transaction_id;
        $invoice_id = $request->invoice_id;
        $order_from = $request->order_from;
        $customer_email = $request->customer_email;
        $biller_email = $request->pay_from_email;
        $customer_id = $request->customer_id;
        $amount = $request->amount;
        $currency = $request->currency;
        $status = $request->status;

        if ($status == '-2') {
            $status_message = 'Failed';
        } else if ($status == '2') {
            $status_message = 'Processed';
        } else if ($status == '0') {
            $status_message = 'Pending';
        } else if ($status == '-1') {
            $status_message = 'Cancelled';
        }
    }

    public function complete(DepositController $controller)
    {
        $track = Session::get('Track');
        $deposit = Deposit::where('trx',$track)->first();
        if($deposit instanceof Deposit){
            return $controller->userDataUpdate($deposit);
        }
    }
   
    public function cancelled(){
        return redirect()->route('deposit.index')->with('alert', 'Payment cancelled.');
    }
}
