<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Support;
use App\Models\SupportComment;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $data['page_title'] = "All Support List";
        $general = General::first();
        $data['all_support'] = Support::orderBy('id', 'DESC')->paginate($general->paginate);
        return view('admin.support.index',$data);
    }

    public function adminReply(Request $request, $support) {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        try{          
            SupportComment::create([
                'ticket_id' => $support,
                'type'      => 0,
                'comment'   => $request->comment,
            ]);

            Support::where('ticket', $support)->update([
                            'status' => 2,
                        ]);

            $ticket = Support::with('user_member')->where('ticket', $support)->firstOrFail();
            $user = $ticket->user_member;
            $shortCodes = [
                'ticket_id' => $ticket->ticket,
                'ticket_subject' => $ticket->subject,
                'reply' => $request->comment,
            ];
            @send_email($user, 'ADMIN_SUPPORT_REPLY', $shortCodes);
                
            return back()->with('success',__('Message Send Successfully'));
        }catch (\Exception $e){
            return back()->with('alert',$e->getMessage());
        }
    }

    public function show($id)
    {
        $data['page_title'] = "View Ticket";
        $data['ticket_object'] = Support::where('ticket', $id)->first();
        $data['ticket_data'] = SupportComment::where('ticket_id', $id)->get();
        return view('admin.support.view_reply', $data);
    }
}
