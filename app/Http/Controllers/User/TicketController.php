<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Support;
use App\Models\SupportComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function userSupportIndex()
    {
        $data['page_title'] = 'My Tickets';
        $data['supports'] = Support::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(15);
        return view('user.support.index', $data);
    }

    public function ticketCreate()
    {
        $data['page_title'] = 'Add New Tickets';
        $data['user'] = Auth::user();
        return view('user.support.create', $data);
    }

    public function ticketStore(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'comment'  => 'required',
        ]);
        $a = strtoupper(md5(uniqid(rand(), true)));
        $support = Support::create([
            'subject'     => $request->subject,
            'ticket'      => substr($a, 0, 8),
            'user_id' => Auth::user()->id,
        ]);
        SupportComment::create([
            'ticket_id' => $support->ticket,
            'type'      => 1,
            'comment'   => $request->comment,
        ]);

        $adminNotification = new Notification();
        $adminNotification->user_id = Auth::user()->id;
        $adminNotification->title = 'New support ticket has opened';
        $adminNotification->click_url = urlPath('support.show', $support->ticket);
        $adminNotification->save();

        return redirect()->route('ticket.user.reply', $support->ticket)->with('message', 'Message Send Successfully');
    }

    public function ticketClose($support)
    {
        Support::where('ticket', $support)
            ->update([
                'status' => 9,
            ]);
        return redirect()->back()->with('message', 'Conversation closed, But you can start again');
    }

    public function ticketReply($support)
    {
        $data['page_title'] = "Support Reply";
        $ticket_object = Support::where('user_id', Auth::user()->id)
            ->where('ticket', $support)->first();
        $ticket_data = SupportComment::where('ticket_id', $support)->get();
        if ($ticket_object == '') {
            return redirect()->route('pagenot.found');
        } else {
            return view('user.support.view', $data, compact('ticket_data', 'ticket_object'));
        }
    }

    public function ticketReplyStore(Request $request, $support)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);
        SupportComment::create([
            'ticket_id' => $support,
            'type'      => 1,
            'comment'   => $request->comment,
        ]);
        Support::where('ticket', $support)
            ->update([
                'status' => 3,
            ]);
        return redirect()->back()->with('message', 'Message Send Successful');
    }
}
