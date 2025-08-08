<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Slider Section";
        $general = General::first();
        $data['slider'] = Slider::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.slider.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            if ($request->image) {
                $size = [851,400];
            }
            $fileName = uploadImage($request->file('image'),'images/slider',null,null,$size);
            Slider::create([
                'image' => $fileName,
                'status' => 1

            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            $slider = Slider::find($id);
            if ($slider->image) {
                $size = [851,400];
            }
            if ($request->file('image')){
                @unlink('public/images/slider/'.$slider->image);
                $fileName = uploadImage($request->file('image'),'images/slider',null,null,$size);
            }else{
                $fileName = $slider->image;
            }
            $slider->update([
                'image' => $fileName,
                'status' => $request->status,
            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $slider = Slider::find($id);
            @unlink('public/images/slider/'.$slider->image);
            $slider->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
