<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function index($lang = false)
    {
        $data['page_title'] = "Language";
        $general = General::first();
        $lang = Language::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.language.index', $data, compact('lang'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
        ]);
        try{
            if ($request->code == 'en' || $request->code == 'EN'){
                return back()->with('alert',__('Default Language'));
            }

            $data = file_get_contents(resource_path('/lang/default.json'));
            $json_file = $request->code.'.json';
            $path = resource_path('lang/'). $json_file;

            File::put($path, $data);

            $in['name'] = $request->name;
            $in['code'] = strtolower($request->code);
            Language::create($in);

            return back()->with('success',__('Create Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $la = Language::find($id);
        $data['page_title'] = "Update ".$la->name." Keywords";
        $json = file_get_contents(resource_path('lang/').$la->code.'.json');
        $data['language'] = Language::all();
        if (empty($json))
        {
            return back()->with('alert',__('File Not Found.'));
        }
        return view('admin.language.edit',$data, compact('json', 'la'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);
        
        try{
            $la = Language::whereId($id)->first();
            $in['name'] = $request->name;
            Language::whereId($id)->update($in);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $la = Language::find($id);
            @unlink(resource_path('lang/').$la->code.'.json');
            $la->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function keyUpdate(Request $request, $id)
    {
        try{
            $lang = Language::find($id);
            $content = json_encode($request->keys);
            if ($content === 'null')
            {
                return back()->with('alert',__('At Least One Field Should Be Fill-up'));
            }
            file_put_contents(resource_path('lang/'). $lang->code . '.json', $content);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function langImport(Request $request)
    {
        $lang = Language::find($request->code);
        $json = file_get_contents(resource_path('lang/').$lang->code.'.json');
        return $json;
    }
}
