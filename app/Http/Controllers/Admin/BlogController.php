<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\General;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $data['page_title'] = "News Section";
        $general = General::first();
        $data['blog'] = Blog::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.blog.index',$data);
    }

    public function newsSearch(Request $request)
    {
        $data['page_title'] = "News Section";
        $general = General::first();
        $blog = Blog::where('title', 'LIKE', "%{$request->title}%")->paginate($general->paginate);
        return view('admin.blog.index', $data, compact('blog','general'));
    }

    public function create()
    {
        $data['page_title'] = "Add News Section";
        $data['blog_category'] = BlogCategory::all();
        return view('admin.blog.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            if ($request->image) {
                $size = [350,195];
            }
            $fileName = uploadImage($request->file('image'),'images/blog',null,null,$size);
            Blog::create([
                'image' => $fileName,
                'title' => $request->title,
                'slug' => Str::slug($request['title'], '-'),
                'description' => $request->description,
                'blog_cat_id' => $request->blog_cat_id,

            ]);
            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit News Section";
        $data['blog'] = Blog::find($id);
        $data['blog_category'] = BlogCategory::all();
        return view('admin.blog.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'sometimes|mimes:jpeg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try{
            $blog = Blog::find($id);
            if ($blog->image) {
                $size = [350,195];
            }
            if ($request->file('image')){
                @unlink('public/images/blog/'.$blog->image);
                $fileName = uploadImage($request->file('image'),'images/blog',null,null,$size);
            }else{
                $fileName = $blog->image;
            }
            $blog->update([
                'image' => $fileName,
                'title' => $request->title,
                'slug' => Str::slug($request['title'], '-'),
                'description' => $request->description,
                'blog_cat_id' => $request->blog_cat_id,
            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $blog = Blog::find($id);
            @unlink('public/images/blog/'.$blog->image);
            $blog->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
