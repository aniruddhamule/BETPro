<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\WithdrawLog;
use Illuminate\Http\Request;
use App\Models\WithdrawMethod;
use Carbon\Carbon;

class WithdrawMethodController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Withdrawal Methods";
        $general = General::first();
        $withdraw = WithdrawMethod::orderBy('id', 'DESC');
        if(request()->search){
            $search     = request()->search;
            $withdraw = $withdraw->where('name', 'LIKE',"%$search%");
        }
        $withdraw = $withdraw->paginate($general->paginate);
        return view('admin.withdraw.index',$data, compact('withdraw'));
    }

    public function create()
    {
        $data['page_title'] = "Withdrawal Methods Add";
        return view('admin.withdraw.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024',
            'min_amo' => 'required|numeric|min:0',
            'max_amo' => 'required|numeric|min:0',
            'chargefx' => 'required|numeric|min:0',
            'chargepc' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'currency' => 'required',
            'processing_day' => 'required'
        ]);
        try{

            if ($request->image) {
                $size = [400,400];
            }

            $fileName = uploadImage($request->file('image'),'images/withdraw',null,null,$size);
            WithdrawMethod::create([
                'image' => $fileName,
                'name' => $request->name,
                'rate' => $request->rate,
                'min_amo' => $request->min_amo,
                'max_amo' => $request->max_amo,
                'chargefx' => $request->chargefx,
                'chargepc' => $request->chargepc,
                'currency' => $request->currency,
                'rate' => $request->rate,
                'processing_day' => $request->processing_day

            ]);

            return back()->with('success',__('Create Successfully'));
        }
        catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Withdrawal Methods Edit";
        $data['withdraw'] = WithdrawMethod::find($id);
        return view('admin.withdraw.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'sometimes|mimes:jpeg,png,bmp,gif,svg,webp|max:1024',
            'min_amo' => 'required|numeric|min:1',
            'max_amo' => 'required|numeric|min:1',
            'chargefx' => 'required',
            'chargepc' => 'required',
            'rate' => 'required',
            'currency' => 'required',
            'processing_day' => 'required',
            'status' => 'required'
        ]);
        try{
            $withdraw = WithdrawMethod::find($id);

            if ($withdraw->image) {
                $size = [400,400];
            }

            if ($request->file('image')){
                @unlink('public/images/withdraw/'.$withdraw->image);
                $fileName = uploadImage($request->file('image'),'images/withdraw',null,null, $size);
            }else{
                $fileName = $withdraw->image;
            }

            $withdraw->update([
                'image' => $fileName,
                'name' => $request->name,
                'rate' => $request->rate,
                'min_amo' => $request->min_amo,
                'max_amo' => $request->max_amo,
                'chargefx' => $request->chargefx,
                'chargepc' => $request->chargepc,
                'rate' => $request->rate,
                'processing_day' => $request->processing_day,
                'currency' => $request->currency,
                'status' => $request->status
            ]);

            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function withdrawRequest()
    {
        $data['page_title'] = "Penting Withdrawal";
        $general = General::first();
        $withdrawLog = WithdrawLog::orderBy('id', 'desc')->where('status', 0)->paginate($general->paginate);
        return view('admin.withdraw.withdraw_request',$data, compact('withdrawLog'));
    }

    public function detailWithdraw($id)
    {
        $data['page_title'] = "Withdrawal Details";
        $withdrawLog = WithdrawLog::findOrFail($id);
        return view('admin.withdraw.withdraw_details',$data, compact('withdrawLog'));
    }

    public function repondWithdraw(Request $request, $id)
    {
        $this->validate($request,[
            'message' => 'required',
        ]);
        $withdraw = WithdrawLog::find($id);
        if ( $withdraw instanceof  WithdrawLog){
            $withdraw->status = $request->status;
            $withdraw->update();
            $user = $withdraw->user;
            if ($request->status == 1 ) {
                $message = $request->message;
                $general = General::first();
                $shortCodes = [
                    'trx' => $withdraw->trx,
                    'amount' => $withdraw->amount,
                    'charge' => $withdraw->charge,
                    'currency' => $general->currency,
                    'rate' => $withdraw->method_rate,
                    'method_name' => $withdraw->method_name,
                    'method_currency' => $withdraw->method_cur,
                    'method_message' => $message
                ];
                @send_email($user, 'WITHDRAW_APPROVE' , $shortCodes);
                return back()->with('success','Paid Complete');
            }else{
                $withdraw->user()->update([
                    'balance' => floatval($user->balance) + floatval($withdraw->amount) + floatval($withdraw->charge)
                ]);
                $message = $request->message;
                $general = General::first();
                $shortCodes = [
                    'trx' => $withdraw->trx,
                    'amount' => $withdraw->amount,
                    'charge' => $withdraw->charge,
                    'currency' => $general->currency,
                    'rate' => $withdraw->method_rate,
                    'method_name' => $withdraw->method_name,
                    'method_currency' => $withdraw->method_cur,
                    'method_message' => $message
                ];
                @send_email($user, 'WITHDRAW_REJECT' , $shortCodes);
                return back()->with('success','Refund Complete');
            }
        }
        return back()->with('alert','Withdraw Log not found');
    }
    public function showWithdrawLog()
    {
        $data['page_title'] = "Withdrawal Log";
        $general = General::first();
        $withdrawLog = WithdrawLog::latest('updated_at')->paginate($general->paginate);
        return view('admin.withdraw.withdraw_log',$data, compact('withdrawLog'));
    }

    public function withdLogSearch(Request $request)
    {
        $data['page_title'] = "Withdrawal Log";
        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
        $withdrawLog = WithdrawLog::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])->paginate(100);
        return view('admin.withdraw.withdraw_log',$data, compact('withdrawLog'));
    }
}
