<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General;
use App\Models\SectionBtn;

class GeneralController extends Controller
{
    public function gnlSetting()
    {
        $data['page_title'] = "General Setting";
        $timezones = json_decode(file_get_contents(resource_path('views/admin/layouts/partials/timezone.json')));
        return view('admin.general.settings',$data, compact('timezones'));
    }

    public function customCss(){
        $page_title = 'Custom CSS';
        $file = 'public/frontend/css/custom.css';
        $file_content = @file_get_contents($file);
        return view('admin.general.custom_css',compact('page_title','file_content'));
    }

    public function seoMng()
    {
        $data['page_title'] = __('SEO Manage');
        return view('admin.general.seo_global',$data);
    }

    public function sectionIndex()
    {
        $data['page_title'] = __('Manage Section');
        return view('admin.general.section',$data);
    }

    public function apiIndex()
    {
        $data['page_title'] = __('Sports Api');
        return view('admin.general.api',$data);
    }

    public function logoFavicon()
    {
        $data['page_title'] = "Logo & Favicon";
        return view('admin.general.logo_favicon', $data);
    }

    public function aboutIndex()
    {
        $data['page_title'] = "About Us";
        return view('admin.front_section.about', $data);
    }

    public function contactIndex()
    {
        $data['page_title'] = "Contact Section";
        return view('admin.front_section.contact', $data);
    }

    public function customCssSubmit(Request $request){
        try{
            $file = 'public/frontend/css/custom.css';
            if (!file_exists($file)) {
                fopen($file, "w");
            }
            file_put_contents($file,$request->css);
            return back()->with('success',__('CSS Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function sectionUpdate(Request $request, $id)
    {
        $request->validate([
            'service_switch' => 'sometimes',
            'about_switch' => 'sometimes',
            'testimonial_switch' => 'sometimes',
            'news_switch' => 'sometimes',
            'event_switch' => 'sometimes',
            'leaderboard_switch' => 'sometimes',
            'contact_switch' => 'sometimes',
        ]);
        try{
            $section_btn = SectionBtn::findOrFail($id);
            $section_btn->update([
                'service_switch' => $request->service_switch ? 1 : 0,
                'about_switch' => $request->about_switch ? 1 : 0,
                'testimonial_switch' => $request->testimonial_switch ? 1 : 0,
                'news_switch' => $request->news_switch ? 1 : 0,
                'event_switch' => $request->event_switch ? 1 : 0,
                'leaderboard_switch' => $request->leaderboard_switch ? 1 : 0,
                'contact_switch' => $request->contact_switch ? 1 : 0,

            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function generalStore(Request $request)
    {
        $gnl = General::first();
        try{

            foreach ($request->all() as $key => $file){
                if ($key != '_token'){
                    $textInputFiledName[] = $key;
                }
            }
            if ($request->file()){
                foreach ($request->file() as $key => $file){
                    if ($key != '_token'){
                        $fileInputFiledName[] = $key;
                    }
                }
            }else{
                $fileInputFiledName = array();
            }

            foreach ($request->except($fileInputFiledName) as $key => $data){
                if ($key != '_token'){
                    $gnl->$key = $data;
                    $gnl->update();
                }
            }

            if($request->timezone){
                $timezoneFile = config_path('timezone.php');
                $content = '<?php $timezone = '.$request->timezone.' ?>';
                file_put_contents($timezoneFile, $content);
            }

            if ($request->hasFile('logo')){
                $request->validate([
                    'logo' => 'sometimes|mimes:jpeg,png,jpg,jpg|max:1024'
                ]);
                uploadImage($request->file('logo'),'images/logo','logo','png');
            }

            if ($request->hasFile('favicon')){
                $request->validate([
                    'favicon' => 'sometimes|mimes:jpeg,png,jpg|max:1024'
                ]);
                if ($request->hasFile('favicon')) {
                    $size = [36,36];
                }
                uploadImage($request->file('favicon'),'images/logo','favicon','png',$size);
            }

            if ($request->hasFile('thumimg')){
                $request->validate([
                    'thumimg' => 'sometimes|mimes:jpeg,png,jpg|max:1024'
                ]);
                if ($request->hasFile('thumimg')) {
                    $size = [1280,720];
                }
                uploadImage($request->file('thumimg'),'images/logo','thumimg','png',$size);
            }

            if ($request->hasFile('about_image')){
                $request->validate([
                    'about_image' => 'sometimes|mimes:jpeg,png,jpg|max:1024'
                ]);
                if ($request->hasFile('about_image')) {
                    $size = [489,557];
                }
                uploadImage($request->file('about_image'),'images/about','about_image','png',$size);
            }

            if ($request->hasFile('front_img')){
                $request->validate([
                    'front_img' => 'sometimes|mimes:jpeg,png,jpg|max:1024'
                ]);
                if ($request->hasFile('front_img')) {
                    $size = [540,715];
                }
                uploadImage($request->file('front_img'),'images/breadcrumb','front_img','png',$size);
            }

            if ($request->hasFile('seo_image')){
                $request->validate([
                    'seo_image' => 'sometimes|mimes:jpeg,png,jpg|max:1024'
                ]);
                uploadImage($request->file('seo_image'),'images/seo/','seo_image','png');
            }

            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function navSideUpdate(Request $request){
        if($request->type == "sidebar"){
            General::first()->update([
                'admin_sidebar' => $request->value
            ]);
        }

        if($request->type == "navbar"){
            General::first()->update([
                'admin_nav' => $request->value
            ]);
        }
        return back()->with('success',__('Update Successfully'));
    }
}
