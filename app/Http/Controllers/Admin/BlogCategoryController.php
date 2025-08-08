<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\General;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $data['page_title'] = "News Category";
        $general = General::first();
        $data['category'] = BlogCategory::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.front_section.blog_category', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try{
            BlogCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request['name'], '-'),
            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try{
            $category = BlogCategory::find($id);
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request['name'], '-'),
            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $category = BlogCategory::find($id);
            $category->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
