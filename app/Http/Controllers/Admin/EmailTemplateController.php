<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Email Templates';
        $general = General::first();
        $data['email_templates'] = EmailTemplate::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.email_template.index', $data);
    }
    
    public function edit($id)
    {
        $email_template = EmailTemplate::findOrFail($id);
        $data['page_title'] = $email_template->name;
        return view('admin.email_template.edit', $data, compact('email_template'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'subj' => 'required',
            'email_body' => 'required',
        ]);
        try{
            $email_template = EmailTemplate::findOrFail($id);
            $email_template->update([
                'subj' => $request->subj,
                'email_body' => $request->email_body,
                'email_status' => $request->email_status ? 1 : 0
            ]);
            return back()->with('success',__('Update Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function emailControl()
    {
        $data['page_title'] = "Email Controls";
        $general = General::first();
        $data['email_description'] = $general->email_description;
        return view('admin.email_template.config', $data, compact('general'));
    }

    public function emailConfigure(Request $request)
    {
        $request->validate([
            'email_method' => 'required',
            'sender_email' => 'required|email',
            'sender_email_name' => 'required',
            'smtp_host' => 'required',
            'smtp_port' => 'required',
            'smtp_username' => 'required',
            'smtp_password' => 'required',
        ]);

        $genrl = General::first();
        config(['basic.sender_email' => $request['sender_email']]);
        config(['basic.sender_email_name' => $request['sender_email_name']]);
        config(['basic.email_description' => $genrl->global_description]);
        config(['basic.email_configuration.name' => $request['email_method']]);
        config(['basic.email_configuration.smtp_host' => $request['smtp_host']]);
        config(['basic.email_configuration.smtp_port' => $request['smtp_port']]);
        config(['basic.email_configuration.smtp_encryption' => $request['smtp_encryption']]);
        config(['basic.email_configuration.smtp_username' => $request['smtp_username']]);
        config(['basic.email_configuration.smtp_password' => $request['smtp_password']]);

        $genrl->sender_email = $request['sender_email'];
        $genrl->sender_email_name = $request['sender_email_name'];
        $genrl->email_description = $genrl->global_description;
        $genrl->email_configuration = [
            'name' => $request['email_method'],
            'smtp_host' => $request['smtp_host'],
            'smtp_port' => $request['smtp_port'],
            'smtp_encryption' => $request['smtp_encryption'],
            'smtp_username' => $request['smtp_username'],
            'smtp_password' => $request['smtp_password']
        ];
        $genrl->save();

        $fp = fopen(base_path() . '/config/basic.php', 'w');
        fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
        fclose($fp);


        $envPath = base_path('.env');
        $env = file($envPath);
        $env = $this->set('MAIL_FROM_ADDRESS', '"' . config('basic.sender_email') . '"', $env);
        $env = $this->set('MAIL_FROM_NAME', '"' . config('basic.sender_email_name') . '"', $env);

        $env = $this->set('MAIL_MAILER', config('basic.email_configuration.name'), $env);

        if (config('basic.email_configuration.name') == 'smtp') {
            $env = $this->set('MAIL_HOST', '"' . config('basic.email_configuration.smtp_host') . '"', $env);
            $env = $this->set('MAIL_PORT', '"' . config('basic.email_configuration.smtp_port') . '"', $env);
            $env = $this->set('MAIL_USERNAME', '"' . config('basic.email_configuration.smtp_username') . '"', $env);
            $env = $this->set('MAIL_PASSWORD', '"' . config('basic.email_configuration.smtp_password') . '"', $env);
            $env = $this->set('MAIL_ENCRYPTION', '"' . config('basic.email_configuration.smtp_encryption') . '"', $env);
        }

        $fp = fopen($envPath, 'w');
        fwrite($fp, implode($env));
        fclose($fp);

        Artisan::call('config:clear');
        Artisan::call('view:clear');

        session()->flash('success', __('Email Configuration Has Been Updated'));
        return back();
    }


    private function set($key, $value, $env)
    {
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            if ($entry[0] == $key) {
                $env[$env_key] = $key . "=" . $value . "\n";
            } else {
                $env[$env_key] = $env_value;
            }
        }
        return $env;
    }


    public function globalControl()
    {
        $data['page_title'] = "Global Template";
        return view('admin.email_template.global', $data);
    }
}
