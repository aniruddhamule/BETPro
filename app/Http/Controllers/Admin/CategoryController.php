<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\General;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Category';
        $general = General::first();
        $category = Category::latest();
        if(request()->search){
            $search     = request()->search;
            $category = $category->where('name', 'LIKE',"%$search%");
        }
        $category = $category->paginate($general->paginate);
        return view('admin.category.index', $data, compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required',
        ]);
        try {
            $slugExist = Category::where('slug', trim($request->name))->count();
            if($slugExist > 0){
                return back()->with('alert', __('Category name already exist.'));
            }
            Category::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'slug' => Str::slug($request['name'], '-'),
                'status' => 1
            ]);
            return back()->with('success', __('Create Successfully'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required',
            'status' => 'required'
        ]);
        try {
            $category = Category::find($id);
            $slugExist = Category::where('id','!=',$category->id)->where('slug', trim($request->name))->count();
            if($slugExist > 0){
                return back()->with('alert', __('Category name already exist.'));
            }
            $category->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'slug' => Str::slug($request['name'], '-'),
                'status' => $request->status
            ]);
            return back()->with('success', __('Update Successfully'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

}
