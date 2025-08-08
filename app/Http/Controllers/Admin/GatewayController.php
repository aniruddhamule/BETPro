<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Automatic Gateways";
        $general = General::first();
        $gateway = PaymentGateway::where('id', '<', 99)->orderBy('id', 'DESC');
        if(request()->search){
            $search     = request()->search;
            $gateway = $gateway->where('name', 'LIKE',"%$search%");
        }
        $gateway = $gateway->paginate($general->paginate);
        return view('admin.gateway.index',$data, compact('gateway'));
    }

    public function ManualIndex()
    {
        $data['page_title'] = "Manual Gateways";
        $general = General::first();
        $gateway = PaymentGateway::where('id', '>', 99)->orderBy('id', 'DESC');
        if(request()->search){
            $search     = request()->search;
            $gateway = $gateway->where('name', 'LIKE',"%$search%");
        }
        $gateway = $gateway->paginate($general->paginate);
        return view('admin.gateway.manual_index',$data, compact('gateway'));
    }

    public function create()
    {
        $data['page_title'] = "Gateway Add";
        return view('admin.gateway.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rate' => 'required|numeric',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024',
            'minimum_deposit_amount' => 'required|numeric',
            'maximum_deposit_amount' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'percentage_charge' => 'required|numeric',
            'gateway_key_one' => 'sometimes|required',
            'gateway_key_two' => 'sometimes|required',
            'gateway_key_three' => 'sometimes|required',
            'gateway_key_four' => 'sometimes|required',
            'status' => 'required',
        ]);


        try{
            $lastGateway = PaymentGateway::latest()->count();
            if ($request->image) {
                $size = [178,107];
            }
            $fileName = uploadImage($request->file('image'),'images/gateway',null,null,$size);
            PaymentGateway::create([
                'id' => $lastGateway + 99,
                'image' => $fileName,
                'name' => $request->name,
                'rate' => $request->rate,
                'minimum_deposit_amount' => $request->minimum_deposit_amount,
                'maximum_deposit_amount' => $request->maximum_deposit_amount,
                'fixed_charge' => $request->fixed_charge,
                'percentage_charge' => $request->percentage_charge,
                'gateway_key_one' => $request->gateway_key_one,
                'gateway_key_two' => $request->gateway_key_two,
                'gateway_key_three' => $request->gateway_key_three,
                'gateway_key_four' => $request->gateway_key_four,
                'status' => $request->status,

            ]);

            return back()->with('success',__('Create Successfully'));
        }
        catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Gateway Edit";
        $data['gateway'] = PaymentGateway::find($id);
        return view('admin.gateway.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'rate' => 'required|numeric',
            'minimum_deposit_amount' => 'required|numeric',
            'maximum_deposit_amount' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'percentage_charge' => 'required|numeric',
            'gateway_key_one' => 'sometimes|required',
            'gateway_key_two' => 'sometimes|required',
            'gateway_key_three' => 'sometimes|required',
            'gateway_key_four' => 'sometimes|required',
            'status' => 'required',
            'image' => 'sometimes|mimes:jpeg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            $gateway = PaymentGateway::find($id);
            if ($gateway->image) {
                $size = [178,107];
            }
            if ($request->file('image')){
                @unlink('public/images/gateway/'.$gateway->image);
                $fileName = uploadImage($request->file('image'),'images/gateway',null,null, $size);
            }else{
                $fileName = $gateway->image;
            }
            $gateway->update([
                'image' => $fileName,
                'name' => $request->name,
                'rate' => $request->rate,
                'minimum_deposit_amount' => $request->minimum_deposit_amount,
                'maximum_deposit_amount' => $request->maximum_deposit_amount,
                'fixed_charge' => $request->fixed_charge,
                'percentage_charge' => $request->percentage_charge,
                'gateway_key_one' => $request->gateway_key_one,
                'gateway_key_two' => $request->gateway_key_two,
                'gateway_key_three' => $request->gateway_key_three,
                'gateway_key_four' => $request->gateway_key_four,
                'status' => $request->status,
            ]);

            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
