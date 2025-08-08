<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Lib\coinPayments;
use App\Models\Deposit;
use App\Models\DepositRequest;
use App\Models\General;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class DepositController extends Controller
{
    public function index(){
        $data['page_title'] = "Deposit";
        $data['gateways'] = PaymentGateway::whereStatus(1)->get();
        return view('user.deposit.index',$data);
    }

    public function userDataUpdate($data)
    {
        if($data->status==0)
        {
            $data['status'] = 1;
            $data->update();

            $user = User::find($data->user_id);
            createTransaction("Deposit via " . $data->gateway->name,$data->amount,$user->balance,$user->balance + $data->amount,1);

            $user['balance'] = $user->balance + $data->amount;
            $user->update();
            $gnl = General::first();
            $shortCodes = [
                'trx' => $data->trx,
                'amount' => $data->amount,
                'charge' => $data->charge,
                'rate' => $data->gateway->rate,
                'currency' => $gnl->currency,
                'method_name' => $data->gateway->name,
                'method_currency' => $gnl->currency,
            ];
            levelCommision($data->user_id, $data->amount);
            @send_email($user, 'DEPOSIT_COMPLETE' , $shortCodes);
            Session::flash('success', 'Deposited ' . $data->amount . ' ' . $gnl->currency . ' successfully');

            $adminNotification = new Notification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'Deposit Successful via '.$data->gateway->name;
            $adminNotification->click_url = urlPath('admin.deposit.depositLog');
            $adminNotification->save();

            return redirect()->route('deposit.index');
        }

        return redirect()->route('deposit.index')->with('alert','Something went wrong');

    }

    public function depositPayNow(Request $request){

        $gatewayId = $request->gateway_id;
        $amount = floatval($request->amount);

        if($gatewayId > 99){
            $this->validate($request, [
                'amount' => 'required|numeric',
                'payment_des'  => 'sometimes',
            ]);
        }

        try {
            $gateway = PaymentGateway::find($gatewayId);
            $charge = (($amount * $gateway->percentage_charge)/100)+ $gateway->fixed_charge;
            $total_amount = floatval($amount) + floatval($charge);
            $usd_amo = floatval($gateway->rate) * $total_amount;
            $trx = getTrx();
            $gnl = General::first();


            // dyanamic Gateway
            $depo['user_id'] = Auth::id();
            $depo['gateway_id'] = $gateway->id;
            $depo['amount'] = $amount;
            $depo['charge'] = $charge;
            $depo['usd_amo'] = round($usd_amo, 2);
            $depo['btc_amo'] = 0;
            $depo['btc_wallet'] = "";
            $depo['trx'] = $trx;
            $depo['try'] = 0;
            $depo['status'] = 0;
            $deposit_table = Deposit::create($depo);

            Session::put('Track', $deposit_table->trx);
            $track = $deposit_table->trx;

            if ($gatewayId == 1){
                return App::call('App\Http\Controllers\User\PayPalController@payment');
            }

           if ($gatewayId == 2){

               $all = file_get_contents("https://blockchain.info/ticker");
               $res = json_decode($all);
               $btcrate = $res->USD->last;
               $amon = $total_amount;
               $usd = $usd_amo;
               $bcoin = round($usd/$btcrate,8);
               $callbackUrl = route('ipn.coinpayemnt');

               $CP = new coinPayments();
               $CP->setMerchantId($gateway->gateway_key_one);
               $CP->setSecretKey($gateway->gateway_key_two);
               $ntrc = $deposit_table->trx;
               $form = $CP->createPayment('Deposit', 'BTC',  $bcoin, $ntrc, $callbackUrl);
               $page_title = $gateway->name;
               return view('user.deposit.payment_views.coinpay',$deposit_table, compact('bcoin','form','page_title','amon', 'gnl'));
            }

            if ($gatewayId == 3){
                $page_title = $gateway->name;
                return view('user.deposit.payment_views.stripe',$deposit_table, compact('track','page_title','gateway','deposit_table'));
            }

            if ($gatewayId == 4) {
                $url = 'https://www.payfast.co.za/eng/process'; //https://sandbox.payfast.co.za​/eng/process
                $user = Auth::user();
                $n = explode(" ",$user->name);
                if(count($n) > 1){
                    $fn =$n['0'];
                    $ln =$n['1'];
                }else{
                    $fn =$user->name;
                    $ln =$user->name;
                }

                $cartTotal = floatval($usd_amo);
                $payFast = array(
                    'merchant_id' => $gateway->gateway_key_one,
                    'merchant_key' => $gateway->gateway_key_two,

                    'return_url' => route('payfast.payment.success'),
                    'cancel_url' => route('payfast.payment.cancel'),
                    'notify_url' => route('payfast.payment.notify'),

                    'name_first' => $fn,
                    'name_last'  => $ln,
                    'email_address'=> $user->email,

                    'm_payment_id' => $deposit_table->trx,
                    'amount' => number_format( sprintf( '%.2f', $cartTotal ), 2, '.', '' ),
                    'item_name' => 'Deposit#'.$deposit_table->trx
                );

                $signature = $this->generateSignature($payFast);
                $payFast['signature'] = $signature;

                $testingMode = true;
                $pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
                $htmlForm = '<form id="PayForm" action="https://'.$pfHost.'/eng/process" method="post">';
                foreach($payFast as $name=> $value)
                {
                    $htmlForm .= '<input name="'.$name.'" type="hidden" value="'.$value.'" />';
                }

                return view('user.deposit.payment_views.payfast',compact('htmlForm'));
            }
            if ($gatewayId == 5){
               $page_title = $gateway->name;
               config([
                   'paystack.publicKey'     => $gateway->gateway_key_one,
                   'paystack.secretKey'     => $gateway->gateway_key_two,
                   'paystack.paymentUrl'     => 'https://api.paystack.co',
                   'paystack.merchantEmail'     => $gateway->gateway_key_three,
               ]);
                return view('user.deposit.payment_views.paystack',$deposit_table, compact('track','page_title','gateway','deposit_table'));

            }

            if ($gatewayId == 6){
                $page_title = $gateway->name;
               return view('user.deposit.payment_views.rave', compact('track','page_title'));
            }

            if ($gatewayId == 7){

                $page_title = $gateway->name;
                return view('user.deposit.payment_views.paytm', compact('track','page_title'));
            }

            if ($gatewayId == 8){

                $skrill = new SkrillPaymentController;
                return $skrill->makePayment();
            }

            if ($gatewayId == 9){

                $page_title = $gateway->name;
                return view('user.deposit.payment_views.authorizepay', compact('track','page_title','usd_amo'));
            }

            if ($gatewayId == 10){
                return App::call('App\Http\Controllers\User\MollieController@preparePayment');
            }

            if ($gatewayId == 11){
                $page_title = $gateway->name;
                return view('user.deposit.payment_views.instamojo', compact('track','page_title'));
            }

            if ($gatewayId == 12){
                $page_title = $gateway->name;
                return view('user.deposit.payment_views.sceurionpay', compact('track','page_title'));
            }

            if ($gatewayId == 13){
                return App::call('App\Http\Controllers\User\CoingateController@prepareData');
            }

            if ($gatewayId == 14){
                return App::call('App\Http\Controllers\User\CoinbasecommerceController@prepareData');
            }
            
            if ($gatewayId == 15){
                $page_title = $gateway->name;
                return view('user.deposit.payment_views.two_checkout', compact('track','page_title','gateway','deposit_table'));
            }

            if($gatewayId > 99){

                $fileName = uploadImage($request->file('receipt_image'),'images/receipt');
                DepositRequest::create([
                    'deposit_id' => $deposit_table->id,
                    'user_id' => Auth::id(),
                    'gateway_id' => $gateway->id,
                    'amount' => $deposit_table->amount,
                    'usd_amo' => $deposit_table->usd_amo,
                    'charge' => $deposit_table->charge,
                    'trx' => $deposit_table->trx,
                    'r_img' => $fileName,
                    'payment_des' => $request->payment_des,
                ]);

                $adminNotification = new Notification();
                $adminNotification->user_id = Auth::id();
                $adminNotification->title = 'Deposit request send successfully via '.$gateway->name;
                $adminNotification->click_url = urlPath('admin.deposit.pending');
                $adminNotification->save();

                $user = User::find($deposit_table->user_id);
                $shortCodes = [
                    'trx' => $deposit_table->trx,
                    'amount' => $deposit_table->amount,
                    'charge' => $deposit_table->charge,
                    'rate' => $deposit_table->gateway->rate,
                    'currency' => $gnl->currency,
                    'method_name' => $deposit_table->gateway->name,
                    'method_currency' => $gnl->currency,
                    'method_message' => $deposit_table->payment_des,
                ];
                @send_email($user, 'DEPOSIT_REQUEST' , $shortCodes);

                return redirect()->route('deposit.index')->with('success', 'Deposit request sent successfully!');
            }
            return redirect()->route('deposit.index')->with('alert', 'Something went wrong please try again latter.');

        }catch (\Exception $e){
            return redirect()->route('deposit.index')->with('alert', $e->getMessage());
        }

    }

    function generateSignature($data, $passPhrase = null) {
        // Create parameter string
        $pfOutput = '';
        foreach( $data as $key => $val ) {
            if(!empty($val)) {
                $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
            }
        }
        // Remove last ampersand
        $getString = substr( $pfOutput, 0, -1 );
        if( $passPhrase !== null ) {
            $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
        }
        return md5( $getString );
    }

    public function depositLog(){
        $data['page_title'] = "Deposit Log";
        $data['deposits'] = Deposit::where('user_id',\auth()->id())->where('status','!=',0)->latest('updated_at')->with('deposit_request_table')->paginate();
        $data['gateways'] = PaymentGateway::where('status', 1)->get();
        return view('user.deposit.log',$data);
    }
}
