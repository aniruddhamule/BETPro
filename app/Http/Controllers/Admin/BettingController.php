<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BetInvest;
use App\Models\BetOption;
use App\Models\Event;
use App\Models\Matche;
use App\Models\BetQuestion;
use App\Models\Category;
use App\Models\General;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BettingController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Tournament Manage';
        $general = General::first();
        $data['category'] = Category::whereStatus(1)->get();
        $events = Event::with('cat')->latest();
        if (request()->search) {
            $search     = request()->search;
            $events = $events->where('name', 'LIKE', "%$search%")->orWhereHas('cat', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            });
        }
        $events = $events->paginate($general->paginate);
        return view('admin.tournament.index', $data, compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'cat_id' => 'required',
        ]);
        try {
            Event::create([
                'name' => $request->name,
                'cat_id' => $request->cat_id,
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
            'cat_id' => 'required',
            'status' => 'required'
        ]);
        try {
            $events = Event::find($id);
            $events->update([
                'name' => $request->name,
                'cat_id' => $request->cat_id,
                'slug' => Str::slug($request['name'], '-'),
                'status' => $request->status
            ]);
            return back()->with('success', __('Update Successfully'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    protected function filterMatches($type)
    {
        $matches = Matche::orderBy('start_date', 'desc');
        $general = General::first();

        if ($type != 'all') {
            $matches = $matches->$type();
        }

        if (request()->search) {
            $search             = request()->search;
            $matches            = $matches->where('team_1', 'LIKE', "%$search%")->orwhere('team_2', 'LIKE', "%$search%")->orWhereHas('cat', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })->orWhereHas('event', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            });
        }

        return $matches->with('event')->paginate($general->paginate);
    }

    public function matches()
    {
        $segments       = request()->segments();
        $type           = end($segments);
        $matches        = $this->filterMatches(end($segments));
        $now = Carbon::now();
        $data['page_title'] = 'All Event';
        $data['events'] = Event::whereStatus(1)->get();
        return view('admin.event.index', $data, compact('matches'));
    }

    public function runMatches()
    {
        $now = Carbon::now();
        $data['page_title'] = 'Running Event';
        $general = General::first();
        $data['events'] = Event::whereStatus(1)->get();
        $matches = Matche::with('event')->where('status', '!=', 2)->where('end_date', '>=', $now)->orderBy('start_date', 'desc');
        if (request()->search) {
            $search     = request()->search;
            $matches = $matches->where('team_1', 'LIKE', "%$search%")->orwhere('team_2', 'LIKE', "%$search%");
        }
        $matches = $matches->paginate($general->paginate);
        return view('admin.event.index', $data, compact('matches'));
    }

    public function upcomeMatches()
    {
        $now = Carbon::now();
        $data['page_title'] = 'Upcoming Event';
        $general = General::first();
        $data['events'] = Event::whereStatus(1)->get();
        $matches = Matche::with('event')->where('status', '!=', 2)->where('start_date', '>=', $now)->orderBy('start_date', 'desc');
        if (request()->search) {
            $search     = request()->search;
            $matches = $matches->where('team_1', 'LIKE', "%$search%")->orwhere('team_2', 'LIKE', "%$search%");
        }
        $matches = $matches->paginate($general->paginate);
        return view('admin.event.index', $data, compact('matches'));
    }

    public function closeMatches()
    {
        $data['page_title'] = 'Closed Event';
        $general = General::first();
        $matches = Matche::with('event')->orderBy('end_date', 'desc')->whereStatus(2);
        if (request()->search) {
            $search     = request()->search;
            $matches = $matches->where('team_1', 'LIKE', "%$search%")->orwhere('team_2', 'LIKE', "%$search%");
        }
        $matches = $matches->paginate($general->paginate);
        return view('admin.event.closed_event', $data, compact('matches'));
    }

    public function saveMatch(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'event_id' => 'required',
            'team_1' => 'required',
            'team_2' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'team_1_image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024',
            'team_2_image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ], [
            'event_id.required' => 'Tournament must  be selected',
            'team_1.required' => 'Event must not be empty',
            'team_2.required' => 'Event must not be empty',
            'start_date.required' => 'Event start date must not be empty',
            'end_date.required' => 'Event end date must not be empty',
        ]);
        try {

            $events = Event::findOrFail($request->event_id);

            // if ($request->team_1_image) {
            //     $size = [80, 80];
            // }
            // if ($request->team_2_image) {
            //     $size = [80, 80];
            // }

            $start_date = $request->start_date . ' ' . $request->start_time;
            $end_date = $request->end_date . ' ' . $request->end_time;

            $fileName = uploadImage($request->file('team_1_image'), 'images/match', null, null);
            $fileName2 = uploadImage($request->file('team_2_image'), 'images/match', null, null);
            Matche::create([
                'team_1_image' => $fileName,
                'team_2_image' => $fileName2,
                'team_1' => $request->team_1,
                'team_2' => $request->team_2,
                'event_id' => $request->event_id,
                'cat_id' => $events->cat_id,
                'start_date' => Carbon::createFromFormat('d/m/Y H:i', $start_date)->format('Y-m-d H:i:s'),
                'end_date' => Carbon::createFromFormat('d/m/Y H:i', $end_date)->format('Y-m-d H:i:s'),
                'team_1_slug' => Str::slug($request['team_1'], '-'),
                'team_2_slug' => Str::slug($request['team_2'], '-'),
                'status' => 1

            ]);
            return back()->with('success', __('Create Successfully'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function updateMatch(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'event_id' => 'required',
            'team_1' => 'required',
            'team_2' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'team_1_image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024',
            'team_2_image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ], [
            'event_id.required' => 'Tournament must  be selected',
            'team_1.required' => 'Event must not be empty',
            'team_2.required' => 'Event must not be empty',
            'start_date.required' => 'Event start date must not be empty',
            'end_date.required' => 'Event end date must not be empty',
        ]);

        try {
            $match = Matche::find($id);
            $events = Event::findOrFail($request->event_id);

            // if ($match->team_1_image) {
            //     $size = [80, 80];
            // }

            // if ($match->team_2_image) {
            //     $size = [80, 80];
            // }

            if ($request->file('team_1_image')) {
                @unlink('public/images/match/' . $match->team_1_image);
                $fileName = uploadImage($request->file('team_1_image'), 'images/match', null, null);
            } else {
                $fileName = $match->team_1_image;
            }

            if ($request->file('team_2_image')) {
                @unlink('public/images/match/' . $match->team_2_image);
                $fileName2 = uploadImage($request->file('team_2_image'), 'images/match', null, null);
            } else {
                $fileName2 = $match->team_2_image;
            }

            $start_date = str_replace('/','-',$request->start_date). ' ' . Carbon::parse($request->start_time)->format('H:i:s');
            $end_date = str_replace('/','-',$request->end_date) . ' ' . Carbon::parse($request->end_time)->format('H:i:s');
    
            $match->update([
                'team_1_image' => $fileName,
                'team_2_image' => $fileName2,
                'team_1' => $request->team_1,
                'team_2' => $request->team_2,
                'event_id' => $request->event_id,
                'cat_id' => $events->cat_id,
                'start_date' => date('Y-m-d H:i:s',strtotime($start_date)),
                'end_date' => date('Y-m-d H:i:s',strtotime($end_date)),
                'team_1_slug' => Str::slug($request['team_1'], '-'),
                'team_2_slug' => Str::slug($request['team_2'], '-'),
                'status' => $request->status
            ]);

            BetQuestion::where('match_id', $match->id)->update([
                'end_time' =>  date('Y-m-d H:i:s',strtotime($end_date))
            ]);

            return back()->with('success', __('Update Successfully'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function viewQuestion($id)
    {
        $data['match_id'] = Matche::findOrFail($id);
        $data['page_title'] = "Question for - " . $data['match_id']->team_1 . ' vs ' . $data['match_id']->team_2;
        $general = General::first();
        $data['questions'] = BetQuestion::where('match_id', $id)->where('end_time', '>', Carbon::now())->paginate($general->paginate);
        return view('admin.event.questions', $data);
    }

    public function saveQuestion(Request $request)
    {
        $this->validate($request, [
            'match_id' => 'required',
            'question' => 'required',
            'end_date' => 'required',
            'end_time' => 'required'
        ]);

        try {
            $end_date = $request->end_date . ' ' . $request->end_time;
            $data = Matche::find($request->match_id);
            $carbonDate = Carbon::createFromFormat('d/m/Y H:i', $end_date)->format('Y-m-d H:i:s');

            if ($data->end_date > $carbonDate) {
                BetQuestion::create([
                    'match_id' => $request->match_id,
                    'end_time' => Carbon::createFromFormat('d/m/Y H:i', $end_date)->format('Y-m-d H:i:s'),
                    'question' => $request->question,
                    'status' => 1

                ]);
                return back()->with('success', __('Create Successfully'));
            }
            return back()->with('alert', __('Fancy Date should be before ' . date('d M, Y - h:i A', strtotime($data->end_date))));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function updateQuestion(Request $request)
    {
        $request->validate([
            'match_id' => 'required',
            'question' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'status' => 'required'
        ]);

        try {
            $data = Matche::find($request->match_id);
            $end_date = date('Y-m-d', strtotime($request->end_date)) . ' ' . Carbon::parse($request->end_time)->format('H:i:s');


            if (Carbon::parse($data->end_date) >= Carbon::createFromFormat('Y-m-d H:i:s', $end_date)->format('Y-m-d H:i:s')) {
                $data_qus = BetQuestion::findOrFail($request->id);
                $data_qus->update([
                    'match_id' => $request->match_id,
                    'end_time' => Carbon::createFromFormat('Y-m-d H:i:s', $end_date)->format('Y-m-d H:i:s'),
                    'question' => $request->question,
                    'status' => $request->status
                ]);
                return back()->with('success', __('Update Successfully'));
            }
            return back()->with('alert', __('Fancy Date should be before ' . date('d M, Y - h:i A', strtotime($data->end_date))));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function viewOption($id)
    {
        $data['ques'] = BetQuestion::with('match')->where('id', $id)->firstOrFail();
        $data['page_title'] = "Question: " . $data['ques']->question . "";
        $general = General::first();
        $data['betoption'] = BetOption::whereQuestion_id($id)->paginate($general->paginate);
        return view('admin.event.options', $data);
    }

    public function createNewOption(Request $request)
    {
        $this->validate($request, [
            'ques_id' => 'required',
            'match_id' => 'required',
            'option_name' => 'required',
            'min_amo' => 'required',
            'bet_limit' => 'required',
            'ratio1' => 'required',
            'ratio2' => 'required'
        ]);

        try {
            BetOption::create([
                'match_id' => $request->match_id,
                'question_id' => $request->ques_id,
                'option_name' => $request->option_name,
                'min_amo' => $request->min_amo,
                'ratio1' => $request->ratio1,
                'ratio2' => $request->ratio2,
                'status' => 1
            ]);
            return back()->with('success', __('Create Successfully'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function updateOption(Request $request)
    {
        $data = BetOption::find($request->id);
        $this->validate(
            $request,
            [
                'option_name' => 'required',
                'ratio1' => 'required|between:0,99.99',
                'ratio2' => 'required|between:0,99.99',
            ],
            [
                'name.required' => 'Option must not be empty',
                'ratio1.required' => 'ratio1 must not be empty',
                'ratio2.required' => 'ratio2 must not be empty',
            ]
        );
        try {
            $in = request()->except('_token');
            $data->fill($in)->save();

            return back()->with('success', __('Update Successfully'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function endDateByQuestion()
    {
        $now = Carbon::now();
        $data['page_title'] = "Awaiting Winner";
        $general = General::first();
        $data['questions'] = BetQuestion::with('match')->where('end_time', '<', $now)->orderBy('end_time', 'desc')->paginate($general->paginate);
        return view('admin.result.awaiting_list', $data);
    }

    public function refundBetInvest(Request $request)
    {
        $general = General::first();
        $betQ = BetQuestion::where('id', $request->question_id)->where('match_id', $request->match_id)->latest()->first();
        $betQ->result = 1;
        $betQ->save();

        $betOption = BetOption::where('question_id', $betQ->id)->where('match_id', $request->match_id)->latest()->get();
        foreach ($betOption as $value) {
            $value->status = 3;  // refunded
            $value->save();
        }

        $winner = BetInvest::where('betquestion_id', $request->question_id)->where('match_id', $request->match_id)->where('status', 0)->latest()->get();
        foreach ($winner as $dd) {
            $user = User::find($dd->user_id);
            $mm = Matche::whereId($request->match_id)->first();
            $tr = getTrx();
            $newBalance = floatval($user->balance) + $dd->invest_amount;
            $msg = $dd->invest_amount . ' ' . $general->currency . " refunded by admin policy." . "\n Event : " . $mm->name . " ( Ques: " . $dd->ques->question . " => " . $dd->betoption->option_name . ")";
            createTransaction($msg, $dd->invest_amount, $user->balance, $newBalance, 4, $user->id, '+');

            $user->balance += $dd->invest_amount;
            $user->save();
            $dd->status = 2; // refunded
            $dd->user_id = $user->id;
            $dd->remaining_balance = $user->balance; // remaining balance
            $dd->update();
        }
        session()->flash('success', 'Refunded Successfully!');
        return back();
    }


    public function awaitingWinnerUserlist($id)
    {
        $data['page_title'] = "Predictors List";
        $data['betQuestion'] = BetQuestion::find($id);
        $general = General::first();
        $data['betInvest'] = BetInvest::where('betquestion_id', $id)->latest()->paginate($general->paginate);
        return view('admin.result.predictor_list', $data);
    }

    public function refundBetInvestSingleUser(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $general = General::first();
        $invest = BetInvest::where('id', $request->id)->where('status', 0)->firstOrFail();
        $user = User::find($invest->user_id);
        $mm = Matche::whereId($invest->match_id)->first();

        $newBalance = floatval($user->balance) + $invest->invest_amount;
        $msg = $invest->invest_amount . ' ' . $general->currency . " refunded by admin policy. <br>" . "\n Event: " . $mm->name . " ( Ques: " . $invest->ques->question . " => " . $invest->betoption->option_name . ")";
        createTransaction($msg, $invest->invest_amount, $user->balance, $newBalance, 4, $user->id, '+');
        $user->balance += $invest->invest_amount;
        $user->save();
        $invest->status = 2; // refunded
        $invest->user_id = $user->id;
        $invest->remaining_balance = $user->balance; // remaining balance
        $invest->update();
        session()->flash('success', 'Refunded Successfully!');
        return back();
    }

    public function viewOptionEndTime($id)
    {
        $data['ques'] = BetQuestion::findOrFail($id);
        $data['page_title'] = $data['ques']->question;
        $general = General::first();
        $data['betoption'] = BetOption::whereQuestion_id($id)->paginate($general->paginate);
        return view('admin.result.threat_list', $data);
    }

    public function makeWinner(Request $request)
    {
       
        $general = General::first();
        $winner = BetInvest::where('match_id', $request->match_id)->where('betquestion_id', $request->ques_id)->where('betoption_id', $request->betoption_id)->where('status', 0)->latest()->get();
        $losser = BetInvest::where('match_id', $request->match_id)->where('betquestion_id', $request->ques_id)->where('betoption_id', '!=', $request->betoption_id)->where('status', 0)->latest()->get();

        foreach ($winner as $data) {
            $return_amo = $data->return_amount;
            $charge = (($data->return_amount - $data->invest_amount) * $general->win_charge) / 100; //percent
            $user = User::find($data->user_id);

            $data->status = 1;
            $data->charge = round($charge, 2);
            $data->update();

            $newBalance = $user->balance + round(($return_amo - $charge), 2);
            $msg = "Event: " . $data->match->name . " - Ques: " . $data->ques->question . ", Threat: " . $data->betoption->option_name . " => Win";
            createTransaction($msg, round(($return_amo - $charge), 2), $user->balance, $newBalance, 4, $user->id, '+');

            $user->balance +=  round(($return_amo - $charge), 2);
            $user->save();
        }
        foreach ($losser as $data) {
            $user = User::find($data->user_id);
            $data->status = -1;
            $data->user_id = $user->id;
            $data->update();
        }

        $betQ = BetQuestion::find($request->ques_id);
        $betQ->result = 1;
        $betQ->update();

        $betStatus = BetOption::find($request->betoption_id);
        $betStatus->status = 2;
        $betStatus->update();

        $betlosser = BetOption::where('id', '!=', $request->betoption_id)->whereQuestion_id($request->ques_id)->whereMatch_id($request->match_id)->get();
        foreach ($betlosser as $data) {
            $data->status = -2;
            $data->update();
        }
        session()->flash('success', 'Make winner Successfully!');
        return back();
    }

    public function betOptionUserlist($id)
    {
        $data['page_title'] = "Prediction User List";
        $data['betoption'] = BetOption::with('question', 'match')->whereId($id)->firstOrFail();
        $general = General::first();
        $data['betInvest'] = BetInvest::with('user')->where('betoption_id', $id)->latest()->paginate($general->paginate);
        return view('admin.result.predictors_option_side', $data);
    }
}
