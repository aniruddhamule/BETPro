<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Extensions";
        $data['extension'] = Extension::orderBy('id', 'DESC')->get();
        return view('admin.extension.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Extension Add";
        $data['extension'] = Extension::all();
        return view('admin.extension.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'script' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            if ($request->image) {
                $size = [36,36];
            }
            $fileName = uploadImage($request->file('image'),'images/extension',null,null,$size);
            Extension::create([
                'image' => $fileName,
                'name' => $request->name,
                'script' => $request->script,
                'status' => 1,

            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Extension Edit";
        $data['extension'] = Extension::find($id);
        return view('admin.extension.edit', $data);
    }

    public function exUpdate(Request $request, $id)
    {
        try{
            $extension = Extension::find($id);
            foreach ($extension->shortcode as $key => $val) {
                $validation_rule = [$key => 'required'];
            }
            $request->validate($validation_rule);

            $shortcode = json_decode(json_encode($extension->shortcode), true);
            foreach ($shortcode as $key => $code) {
                $shortcode[$key]['value'] = $request->$key;
            }

            $extension->shortcode = $shortcode;
            $extension->script = $request->app_key;
            $extension->save();

            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function activate(Request $request)
    {
        try{
            $request->validate(['id' => 'required|integer']);
            $extension = Extension::findOrFail($request->id);
            $extension->status = 1;
            $extension->save();

            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function deactivate(Request $request)
    {
        try{
            $request->validate(['id' => 'required|integer']);
            $extension = Extension::findOrFail($request->id);
            $extension->status = 0;
            $extension->save();

            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

}
