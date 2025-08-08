<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Section";
        $general = General::first();
        $data['section'] = Section::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.section.index',$data);
    }

    public function create()
    {
        $data['page_title'] = "Section Add";
        return view('admin.section.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'required',
            'description' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{

            $fileName = uploadImage($request->file('image'),'images/section');
            Section::create([
                'image' => $fileName,
                'title' => $request->title,
                'description' => $request->description,
                'sub_title' => $request->sub_title,

            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Section Edit";
        $data['section'] = Section::find($id);
        return view('admin.section.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'required',
            'description' => 'required',
            'image' => 'sometimes|mimes:jpeg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            $section = Section::find($id);

            if ($request->file('image')){
                @unlink('public/images/section/'.$section->image);
                $fileName = uploadImage($request->file('image'),'images/section');
            }else{
                $fileName = $section->image;
            }
            $section->update([
                'image' => $fileName,
                'title' => $request->title,
                'sub_title' => $request->sub_title,
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
            $section = Section::find($id);
            @unlink('public/images/section/'.$section->image);
            $section->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
