<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Subscriber;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SubscriberController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Subscriber Manager';
        $general = General::first();
        $data['subscribers'] = Subscriber::latest()->paginate($general->paginate);
        return view('admin.subscriber.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Send Email to Subscribers';
        return view('admin.subscriber.send_email', $data);
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);
       
        try{
            $subject = $request->subject;
            $message = $request->message;
            if (!Subscriber::first()) return back()->withInput()->with('alert', 'No subscribers to send email.');

            $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber) {
                $name = explode('@', $subscriber->email)[0];
                @send_email($subscriber->email,$name,$subject,$message);
            }
            return back()->with('success',__('Mail Send Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $subscribers = Subscriber::find($id);
            $subscribers->delete();
            Session::flash('success',__('Delete Successfully'));
            return true;
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }
}
