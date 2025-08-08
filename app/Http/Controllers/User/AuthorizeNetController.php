<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use net\authorize\api\controller\CreateTransactionController;
use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\TransactionRequestType;

class AuthorizeNetController extends Controller
{
    public $paymentGateWay;

    public function __construct() {
        $gateWay = PaymentGateway::find(9);
        $this->paymentGateWay = $gateWay;
        config([
            'authorize.login_id'          => $gateWay->gateway_key_one,
            'authorize.transaction_key'   => $gateWay->gateway_key_two
        ]);
    }

    public function pay() {
        return view('user.deposit.payment_views.authorizepay');
    }

    public function handleonlinepay(Request $request, DepositController $controllers) {
        $input = $request->input();
        $gateWay = PaymentGateway::find(9);
        $this->paymentGateWay = $gateWay;
        
        $merchantAuthentication = new MerchantAuthenticationType();
        config([
            'authorize.login_id'          => $merchantAuthentication->setName($gateWay->gateway_key_one),
            'authorize.transaction_key'   => $merchantAuthentication->setTransactionKey($gateWay->gateway_key_two)
        ]);

        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);
        
        $creditCard = new CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($input['expiration-year'] . "-" .$input['expiration-month']);
        $creditCard->setCardCode($input['cvv']);

        $paymentOne = new PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $transactionRequestType = new TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($input['amount']);
        $transactionRequestType->setPayment($paymentOne);

        $transactionRequest = new CreateTransactionRequest();
        $transactionRequest->setMerchantAuthentication($merchantAuthentication);
        $transactionRequest->setRefId($refId);
        $transactionRequest->setTransactionRequest($transactionRequestType);

        $controller = new CreateTransactionController($transactionRequest);
        $response = $controller->executeWithApiResponse(ANetEnvironment::SANDBOX);
    
        if ($response != null) {
            if ($response->getMessages()->getResultCode() == "Ok") {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "success"; 
                    
                    $track = Session::get('Track');
                    $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
                    
                    return $controllers->userDataUpdate($data);
                    
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error";                                    

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error";                                    
                    }
                }
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error";                                    

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error";                    
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error";
                }                
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "error";
        }
        return redirect()->route('deposit.index')->with($msg_type, $message_text);
    }

}
