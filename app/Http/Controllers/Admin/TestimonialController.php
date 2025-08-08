<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Session;

class TestimonialController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Testimonial Section";
        $general = General::first();
        $data['testimonial'] = Testimonial::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.front_section.testimonial', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'sometimes|mimes:jpeg,png,bmp,gif,svg,webp|max:2024',
            'name' => 'required',
            'designation' => 'required',
        ]);
        try{
            if ($request->image) {
                $size = [76,76];
            }
            $fileName = uploadImage($request->file('image'),'images/testimonial',null,null,$size);
            Testimonial::create([
                'image' => $fileName,
                'name' => $request->name,
                'designation' => $request->designation,
            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'sometimes|mimes:jpeg,png,bmp,gif,svg,webp|max:1024',
            'name' => 'required',
            'designation' => 'required',
        ]);
        try{
            $testimonial = Testimonial::find($id);
            if ($testimonial->image) {
                $size = [76,76];
            }
            if ($request->file('image')){
                @unlink('public/images/testimonial/'.$testimonial->image);
                $fileName = uploadImage($request->file('image'),'images/testimonial',null,null,$size);
            }else{
                $fileName = $testimonial->image;
            }
            $testimonial->update([
                'image' => $fileName,
                'name' => $request->name,
                'designation' => $request->designation,
            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $testimonial = Testimonial::find($id);
            @unlink('public/images/testimonial/'.$testimonial->image);
            $testimonial->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
