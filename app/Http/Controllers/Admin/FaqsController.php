<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\General;
use Illuminate\Support\Facades\Session;

class FaqsController extends Controller
{
    public function index()
    {
        $data['page_title'] = "FAQ Section";
        $general = General::first();
        $data['faq'] = Faq::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.front_section.faq', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        try{
            Faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        try{
            $faq = Faq::find($id);
            $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $faq = Faq::find($id);
            $faq->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
