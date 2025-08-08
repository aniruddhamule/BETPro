<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BetInvest;
use App\Models\General;

class BetLogController extends Controller
{
    protected $page_title;

    protected function filterBets($type){

        $bets               = BetInvest::latest();
        $general            = General::first();
        $this->page_title   = ucfirst($type). ' Bets';

        if($type != 'all'){
            $bets = $bets->$type();
        }

        if(request()->search){
            $search  = request()->search;
            $bets    = $bets->whereHas('user', function ($user) use ($search) {
                            $user->where('name', 'like',"%$search%");
                        })->orWhereHas('ques', function ($ques) use ($search) {
                            $ques->where('question', 'like',"%$search%");
                        })->orWhereHas('ques.match', function ($ques) use ($search) {
                            $ques->where('team_1', 'LIKE',"%$search%")->orwhere('team_2', 'LIKE',"%$search%");
                        });

            $this->page_title    = "Search Result for '$search'";
        }

        return $bets->with(['user','match','ques','betoption'])->paginate($general->paginate);
    }

    public function index()
    {
        $segments       = request()->segments();
        $type           = end($segments);
        $bets           = $this->filterBets(end($segments));
        $page_title      = $this->page_title;

        return view('admin.event.log',compact('page_title', 'bets'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $general = General::first();
        $page_title = 'Bet Search - ' . $search;

        $bets = BetInvest::whereHas('user', function ($user) use ($search) {
            $user->where('name', 'like',"%$search%");
        })->orWhereHas('ques', function ($ques) use ($search) {
            $ques->where('question', 'like',"%$search%");
        })->with(['user','match','ques','betoption'])
        ->latest()
        ->paginate($general->paginate);

        return view('admin.event.log',compact('page_title', 'bets', 'search'));
    }
}
