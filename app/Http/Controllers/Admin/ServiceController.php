<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Service Section";
        $general = General::first();
        $data['service'] = Service::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.front_section.service', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            $fileName = uploadImage($request->file('image'),'images/service');
            Service::create([
                'image' => $fileName,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            $service = Service::find($id);
            if ($request->file('image')){
                @unlink('public/images/service/'.$service->image);
                $fileName = uploadImage($request->file('image'),'images/service');
            }else{
                $fileName = $service->image;
            }
            $service->update([
                'image' => $fileName,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $service = Service::find($id);
            @unlink('public/images/service/'.$service->image);
            $service->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
