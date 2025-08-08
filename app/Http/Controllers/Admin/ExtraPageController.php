<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExtraPage;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ExtraPageController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Extra Pages";
        $general = General::first();
        $data['extra_page'] = ExtraPage::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.extra_pages.index',$data);
    }

    public function create()
    {
        $data['page_title'] = "Extra Pages Add";
        return view('admin.extra_pages.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        try{
            ExtraPage::create([
                'title' => $request->title,
                'slug' => Str::slug($request['title'], '-'),
                'description' => $request->description,

            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Extra Pages Edit";
        $data['extra_page'] = ExtraPage::find($id);
        return view('admin.extra_pages.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        try{
            $extra_page = ExtraPage::find($id);
            $extra_page->update([
                'title' => $request->title,
                'slug' => Str::slug($request['title'], '-'),
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
            $extra_page = ExtraPage::find($id);
            $extra_page->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
