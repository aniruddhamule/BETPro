<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositRequest;
use App\Models\General;
use App\Models\PaymentGateway;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepositController extends Controller
{
    public function pending() {
        $general = General::first();
        $data['deposits'] = DepositRequest::where('status', 0)->latest()->paginate($general->paginate);
        $data['page_title'] = 'Pending Deposit Request';
        return view('admin.gateway.requests', $data);
    }

    public function acceptedRequests() {
        $general = General::first();
        $data['deposits'] = DepositRequest::where('status', 1)->latest()->paginate($general->paginate);
        $data['page_title'] = 'Accepted Deposit Request';
        return view('admin.gateway.requests', $data);
    }

    public function rejectedRequests() {
        $general = General::first();
        $data['deposits'] = DepositRequest::where('status', -1)->latest()->paginate($general->paginate);
        $data['page_title'] = 'Rejected Deposit Request';
        return view('admin.gateway.requests', $data);
    }

    public function showReceipt() {
        $dID = $_GET['dID'];
        $deposit = DepositRequest::find($dID);
        return $deposit;
    }

    public function accept(Request $request) {
        try{
            $gs = General::first();
            $gt= PaymentGateway::find($request->gid);
            $dr = DepositRequest::find($request->dID);

            $dr->status = 1;
            $dr->save();
            $user = User::find($dr->user_id);
            $newBalance = $user->balance + $dr->amount;
            createTransaction('Deposit via '.$gt->name, $dr->amount,$user->balance,$newBalance,1,$user->id);
            $user->balance = $newBalance;
            $user->save();
            $shortCodes = [
                'trx' => $dr->trx,
                'amount' => $dr->amount,
                'charge' => $dr->charge,
                'rate' => $dr->gateway->rate,
                'currency' => $gs->currency,
                'method_name' => $dr->gateway->name,
                'method_currency' => $gs->currency,
            ];
            @send_email($user, 'DEPOSIT_APPROVE' , $shortCodes);
            Session::flash('success', 'Request has been accepted successfully');
            return redirect()->back();
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function depositLog() {
        $data['page_title'] = 'Deposit Log';
        $general = General::first();
        $data['deposits'] = Deposit::latest()->paginate($general->paginate);
        return view('admin.gateway.deposits', $data);
    }

    public function depoLogSearch(Request $request)
    {
        $data['page_title'] = "Deposit Log";
        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
        $deposits = Deposit::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])->paginate(100);
        return view('admin.gateway.deposits',$data, compact('deposits'));
    }

    public function rejectReq(Request $request) {
        try{
            $gs = General::first();
            $dr = DepositRequest::find($request->dID);
            $dr->status = -1;
            $dr->save();
            $user = User::find($dr->user_id);
            $shortCodes = [
                'trx' => $dr->trx,
                'amount' => $dr->amount,
                'charge' => $dr->charge,
                'rate' => $dr->gateway->rate,
                'currency' => $gs->currency,
                'method_name' => $dr->gateway->name,
                'method_currency' => $gs->currency,
            ];
            @send_email($user, 'DEPOSIT_REJECT' , $shortCodes);
            Session::flash('success', 'Request has been rejected');
            return redirect()->back();
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }

    }
}
