<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdvertiseController extends Controller
{
    public function indexBanner()
    {
        $data['page_title'] = "Banner Advertise";
        $general = General::first();
        $data['advertise'] = Advertise::where('image', '!=', null)->paginate($general->paginate);
        $session = "banner";
        return view('admin.advertise.index', $data, compact('session'));
    }

    public function indexScript()
    {
        $data['page_title'] = "Advertise";
        $general = General::first();
        $data['advertise'] = Advertise::where('script', '!=', null)->paginate($general->paginate);
        $session = "script";
        return view('admin.advertise.index', $data, compact('session'));
    }

    public function create()
    {
        $data['page_title']  = "Create Advertise";
        return view('admin.advertise.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024',
            'image_redirect_url' => 'sometimes',
            'image_type' => 'sometimes',
            'script' => 'sometimes'
        ]);

        try{

            if ($request->image_size == 'leaderboard') {
                $size = [728,90];
            }elseif ($request->image_size == 'large-Leaderboard') {
                $size = [970,90];
            }elseif ($request->image_size == 'square') {
                $size = [250,250];
            }elseif ($request->image_size == 'small-square') {
                $size = [200,200];
            }elseif ($request->image_size == 'medium-rectangle') {
                $size = [300,250];
            }else{
                $size = [160,600];
            }

            $fileName = uploadImage($request->file('image'),'images/advertise',null,null,$size);

            if($request->type == 1){
                Advertise::create([
                    'image' => $fileName,
                    'image_type' => $request->image_size,
                    'image_redirect_url' => $request->image_redirect_url,
                    'clicks' => 0,
                    'status' => 1,
                ]);
            }else{
                advertise::create([
                    'script' => $request->script,
                    'clicks' => 0,
                    'status' => 1,
                ]);
            }

            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Advertise";
        $advertise = Advertise::find($id);
        if ($advertise->image != null){
            $session = "banner";
            return view('admin.advertise.edit', $data, compact('session', 'advertise'));

        }elseif ($advertise->script != null){
            $session = "script";
            return view('admin.advertise.edit', $data, compact('session', 'advertise'));
        }else{
            return back()->with('alert', 'Something Wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            $advertise = Advertise::find($id);

            if ($request->image_size == 'leaderboard') {
                $size = [728,90];
            }elseif ($request->image_size == 'large-Leaderboard') {
                $size = [970,90];
            }elseif ($request->image_size == 'square') {
                $size = [250,250];
            }elseif ($request->image_size == 'small-square') {
                $size = [200,200];
            }elseif ($request->image_size == 'medium-rectangle') {
                $size = [300,250];
            }else{
                $size = [160,600];
            }

            if ($request->file('image')){
                @unlink(public_path('images/advertise/'.$advertise->image));
                $fileName = uploadImage($request->file('image'),'images/advertise',null,null,$size);
            }else{
                $fileName = $advertise->image;
            }

            if($request->type == 1){
                $advertise->update([
                    'image' => $fileName,
                    'image_type' => $request->image_size,
                    'image_redirect_url' => $request->image_redirect_url,
                ]);
            }else{
                $advertise->update([
                    'script' => $advertise->script,
                ]);
            }
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $advertise = Advertise::find($id);
            @unlink(public_path('images/advertise/'.$advertise->image));
            $advertise->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
