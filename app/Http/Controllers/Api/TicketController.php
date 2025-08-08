<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Support;
use App\Models\SupportComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function userSupportIndex()
    {
        $data['page_title'] = 'My Tickets';
        $data['supports'] = Support::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(15);
        $data['success'] = true;
        return response()->json($data);
    }

    public function ticketCreate()
    {
        $data['page_title'] = 'Add New Tickets';
        $data['user'] = Auth::user();
        $data['success'] = true;
        return response()->json($data);
    }

    public function ticketStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'comment'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
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

            return response()->json([
                'success' => true,
                'message' => 'Message Send Successfully.'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function ticketClose($support)
    {
        Support::where('ticket', $support)
            ->update([
                'status' => 9,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Conversation closed, But you can start again'
        ]);
    }

    public function ticketReply($support)
    {
        $data['page_title'] = "Support Reply";
        $data['ticket_object'] = Support::where('user_id', Auth::user()->id)
            ->where('ticket', $support)->first();
        $data['ticket_data'] = SupportComment::where('ticket_id', $support)->get();
        if ($data['ticket_object'] == '') {
            return response()->json([
                'success' => false,
                'message' => 'Not Found'
            ], 500);
        } else {
            $data['success'] = true;
            return response()->json($data);
        }
    }

    public function ticketReplyStore(Request $request, $support)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try{
            SupportComment::create([
                'ticket_id' => $support,
                'type'      => 1,
                'comment'   => $request->comment,
            ]);
            Support::where('ticket', $support)
                ->update([
                    'status' => 3,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Message Send Successfully.'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ], 500);
        }
    }
}
