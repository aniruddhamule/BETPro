<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use App\Models\Social;
use Illuminate\Support\Facades\Session;

class SocialController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Social Section";
        $general = General::first();
        $data['social'] = Social::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.front_section.social', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required',
            'link' => 'required',
        ]);
        try{
            Social::create([
                'icon' => $request->icon,
                'link' => $request->link,
            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'icon' => 'required',
            'link' => 'required',
        ]);
        try{
            $social = Social::find($id);
            $social->update([
                'icon' => $request->icon,
                'link' => $request->link,
            ]);

            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $social = Social::find($id);
            $social->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
