<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\ExtraPage;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Social;
use App\Models\User;
use App\Models\Matche;
use App\Lib\GoogleAuthenticator;
use App\Models\BetInvest;
use App\Models\BetQuestion;
use App\Models\Event;
use App\Models\Game;
use App\Models\General;
use App\Models\Language;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BetOption;
use App\Models\Category;
use App\Models\PaymentGateway;
use App\Models\Slider;
use App\Services\OddsApi;
use DateTime;
use DateTimeZone;

class UiController extends Controller
{
    public function index()
    {
        $general = General::first();
        $now = Carbon::now();
        $today = Carbon::today();
        $data['testimonial'] = Testimonial::get();
        $data['service'] = Service::get();
        $data['social'] = Social::get();
        $data['faqs'] = Faq::get();
        $data['gateways'] = PaymentGateway::where('status', 1)->get();
        $data['slider'] = Slider::whereStatus(1)->get();
        $data['extra_page'] = ExtraPage::get();
        $data['news'] = Blog::latest()->limit(3)->get();
        $data['category'] = Category::whereStatus(1)
        ->whereHas('event',function($q){
            $q->whereStatus(1);
        })->whereHas('matches',function($q){
            $q->whereStatus(1);
        })
        ->get();

        $data['matches'] = Matche::runningForMatch()->latest()
        ->with([
            'questions'=>function($q){
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            },
            'questions.options'=>function($q){
                $q->whereStatus(1);
            }
        ])->paginate(3);

        $data['up_com_matche'] = Matche::whereStatus(1)->UpcomingMatch()->latest()->paginate(3);
        $date = Carbon::today()->subDays(7);

        $weeklyLeader = BetInvest::with('user')->where('created_at', '>=', $date)->where('status', '!=', 2)->groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as total_predictions'),  DB::raw('sum(invest_amount) as investAmount'))
            ->limit(5)
            ->orderBy('investAmount', 'desc')
            ->get();

        $leader = BetInvest::with('user')->where('status', '!=', 2)->groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as total_predictions'),  DB::raw('sum(invest_amount) as investAmount'))
            ->orderBy('investAmount', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.index', $data, compact('weeklyLeader', 'leader'));
    }

    public function allEvents()
    {
        $now = Carbon::now();
        $general = General::first();
        $data['matches'] = Matche::whereStatus(1)->where('status', '!=', 2)
            ->where('end_date', '>', $now)->orderBy('start_date', 'asc')->limit(10)
            ->whereHas('questions', function ($q) {
                $q->whereStatus(1);
            })->paginate($general->paginate);

        return view('frontend.index', $data);
    }

    public function allFinished()
    {
        $data['matches'] = Matche::whereStatus(2)->CompletedMatch()->orderBy('start_date', 'asc')->paginate(3);
        return view('frontend.index', $data);
    }

    public function allLiveMatch()
    {
        $data['matches'] = Matche::runningForMatch()->latest()
        ->with([
            'questions'=>function($q){
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            },
            'questions.options'=>function($q){
                $q->whereStatus(1);
            }
        ])->paginate(3);

        return view('frontend.index', $data);
    }

    public function allUpComMatch()
    {
        $data['matches'] = Matche::whereStatus(1)->UpcomingMatch()->latest()->paginate(3);
        return view('frontend.index', $data);
    }

    public function policyIndex($slug = null)
    {
        $now = Carbon::now();
        $policy = ExtraPage::whereSlug($slug)->firstOrFail();
        $data['page_title'] = "$policy->title";
        return view('frontend.extra_page', $data, compact('policy'));
    }

    public function tournament($cat_slug = null, $slug = null)
    {
        $tournament = Event::whereSlug($slug)->first();
        $data['page_title'] = "$tournament->name";
        $data['matches'] = Matche::runningForMatch()->latest()->where('event_id', $tournament->id)->whereStatus(1)
        ->with([
            'questions'=>function($q){
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            },
            'questions.options'=>function($q){
                $q->whereStatus(1);
            }
        ])->paginate(3);
        $data['users'] = User::count();
        $data['totalPrediction'] = BetInvest::count();

        return view('frontend.index', $data);
    }

    public function categories($slug)
    {
        $now = Carbon::now();
        $general = General::first();
        $category = Category::whereSlug($slug)->where('status', 1)->firstOrFail();
        $data['page_title'] = "$category->name";
        $data['tournament'] = Event::where('cat_id', $category->id)->where('status', 1)->get();
        $data['matches'] = Matche::with('event')->where('cat_id', $category->id)->whereStatus(1)->where('end_date', '>', $now)->orderBy('start_date', 'asc')
            ->whereHas('questions', function ($q) {
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            })
            ->paginate($general->paginate);
        $data['users'] = User::count();
        $data['totalPrediction'] = BetInvest::count();
        return view('frontend.index', $data);
    }

    public function aboutIndex()
    {
        $data['page_title'] = "About Us";
        $data['social'] = Social::get();
        $data['extra_page'] = ExtraPage::get();
        return view('frontend.about', $data);
    }

    public function newsIndex()
    {
        $data['page_title'] = "News";
        $data['news'] = Blog::paginate(12);
        $data['social'] = Social::get();
        $data['extra_page'] = ExtraPage::get();
        return view('frontend.news.news', $data);
    }
    
    public function moreQusDetails($id)
    {
        $matches = Matche::runningForMatch()->findOrFail($id);
        $data['questions']  = BetQuestion::where('match_id', $matches->id)->whereStatus(1)->with(['options'=>function($q){
            $q->where('status', 1);
        }])->get();
        $data['page_title']  = $matches->team_1. ' vs ' .$matches->team_2.' - Questions';
        $data['categories'] = Category::where('status', 1)->with('event')->latest()->get();
        return view('frontend.more_qus', $data);
    }

    public function newsDetails($slug = null, $id)
    {
        $data['page_title'] = "News Details";
        $news = Blog::findOrFail($id);
        $data['recent_post'] = Blog::latest('created_at')->take(3)->get();
        return view('frontend.news.news_details', $data, compact('news'));
    }

    public function contactIndex()
    {
        $data['page_title'] = "Contact Us";
        $data['social'] = Social::get();
        $data['extra_page'] = ExtraPage::get();
        return view('frontend.contact', $data);
    }

    public function contactSend(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:91',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);

        try {
            $general = General::first();
            $basicEmail = $general->sender_email;
            $name = $request->name;
            $email_from = $request->email;
            $requestMessage = $request->message;
            $subject = $request->subject;

            $email_body = json_decode($general->email_description);

            $message = str_replace("{{name}}", 'Sir', $email_body);
            $message = str_replace("{{message}}", $requestMessage, $message);

            $user['name'] = $name;
            $user['email'] = $email_from;
            $user['requestMessage'] = $requestMessage;
            $user['subject'] = $subject;
            $user['message'] = $message;

            send_email($user, 'contact-mail');

            return back()->with('success', __('Mail has been sent'));
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function authorization()
    {
        $data['page_title'] = "Verification";
        if (Auth::user()->tfver == '1' && Auth::user()->status == '1' && Auth::user()->emailv == 1 && Auth::user()->smsv == 1) {
            return redirect('home');
        } else {
            return view('user.auth.notauthor', $data);
        }
    }

    public function sendemailver()
    {
        $user = Auth::user();
        $chktm = $user->vsent + 1000;
        if ($chktm > time()) {
            $delay = $chktm - time();
            return back()->with('alert', 'Please Try after ' . $delay . ' Seconds');
        } else {
            $code = substr(rand(), 0, 6);
            $user['vercode'] = $code;
            $user['vsent'] = time();
            $user->save();
            $shortCodes = [
                'code' => $code
            ];
            @send_email($user, 'EVER_CODE', $shortCodes);
            return back()->with('success', 'Email verification code sent succesfully');
        }
    }

    public function emailverify(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);
        $user = Auth::user();

        $code = $request->code;
        if ($user->vercode == $code) {
            $user['emailv'] = 0;
            $user['vercode'] = str::random(10);
            $user['vsent'] = 0;
            $user->save();
            return redirect('home')->with('success', 'Email Verified');
        } else {
            return back()->with('alert', 'Wrong Verification Code');
        }
    }

    public function verify2fa(Request $request)
    {
        $user = User::find(Auth::id());
        $this->validate(
            $request,
            [
                'code' => 'required',
            ]
        );
        $ga = new GoogleAuthenticator();

        $secret = $user->secretcode;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['tfver'] = 0;
            $user->save();
            return redirect('home')->with('success', 'Verification Successful.');
        } else {
            return back()->with('alert', 'Wrong Verification Code');
        }
    }

    public function changeLang($lang)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function subscriberStore(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:subscribers',
        ]);
        try {
            Subscriber::create([
                'email' => $request->email,
            ]);
            return back()->with('success', 'Subscribe Successfully');
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $data['page_title'] = "News";
        $search = $request->input('title');
        $news = blog::where('title', 'LIKE', '%' . $search . '%')->paginate(36);
        $data['social'] = Social::get();
        $data['extra_page'] = ExtraPage::get();
        return view('frontend.news.news', $data, compact('search', 'news'));
    }

    public function cronAction()
    {
        $now = Carbon::now();
        Matche::where('end_date', '<', $now)->where('status', 1)->update(['status' => 2]);
        BetQuestion::where('end_time', '<', $now)->where('status', 1)->update(['status' => 2]);
    }

    public function apiEventMatch($event_key)
    {
        try {
            if (!is_null($event_key)) {
                set_time_limit(0);
                $getSports = OddsApi::groupBySports($event_key);

                $general = General::first();

                if (!is_null($general->market_key)) {
                    $market_key = $general->market_key;
                } else {
                    $market_key = 'unibet';
                }

                if (!is_null($general->min_amt)) {
                    $min_amt = $general->min_amt;
                } else {
                    $min_amt = '1';
                }

                if (!is_null($general->max_amt)) {
                    $max_amt = $general->max_amt;
                } else {
                    $max_amt = '10000';
                }


                $sourceTimezone = new DateTimeZone('UTC');
                $destinationTimezone = new DateTimeZone('Asia/Dhaka');

                foreach ($getSports as $data) {
                    $bookmakers = $data->bookmakers;
                    $market_odd = array_filter($bookmakers, function ($var) use ($market_key) {
                        return ($var->key == $market_key);
                    });

                
                    $event = Event::where('key', $data->sport_key)->first();
                    if ($event instanceof Event) {
                        $team_one = $data->home_team;
                        $team_two = $data->away_team;

                        $team_one_flag = null;
                        $team_two_flag = null;

                        $dtOne = new DateTime(date('Y-m-d H:i:s', $data->commence_time), $sourceTimezone);
                        $dtOne->setTimeZone($destinationTimezone);
                        $start_date = $dtOne->format('Y-m-d H:i:s');


                        $end_date = Carbon::parse($start_date)->addHours(3)->format('Y-m-d H:i:s');
                        $sport = Matche::where('team_1', $team_one)->where('team_2', $team_two)
                            ->whereStatus(1)->where('start_date', $start_date)->count();

                        if ($sport == 0) {
                            $matche = Matche::create([
                                'team_1_image' => $team_one_flag,
                                'team_2_image' => $team_two_flag,
                                'team_1' => $team_one,
                                'team_2' => $team_two,
                                'event_id' => $event->id,
                                'cat_id' => $event->cat_id,
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'team_1_slug' => Str::slug($team_one, '-'),
                                'team_2_slug' => Str::slug($team_two, '-'),
                                'status' => 1
                            ]);

                            if ($matche) {
                                $bet_qus = BetQuestion::create([
                                    'match_id' => $matche->id,
                                    'end_time' => $end_date,
                                    'question' => __('Who will win?'),
                                    'status' => 1
                                ]);

                                if (isset($data->bookmakers) && !empty($data->bookmakers) && $bet_qus) {
                                    $bookmakers = $data->bookmakers;
                                    $market_odd = array_filter($bookmakers, function ($var) use ($market_key) {
                                        return ($var->key == $market_key);
                                    });

                                    $market_odd = reset($market_odd);
                                    $bet_opt = $market_odd->markets;

                                    if (isset($bet_opt) && !empty($bet_opt) && !is_null($bet_opt)) {
                                        foreach ($bet_opt as $opt) {
                                            foreach($opt->outcomes as $op){
                                                BetOption::create([
                                                    'match_id' => $matche->id,
                                                    'question_id' => $bet_qus->id,
                                                    'option_name' => $op->name,
                                                    'min_amo' => $min_amt,
                                                    'bet_limit' => $max_amt,
                                                    'ratio1' => 1,
                                                    'ratio2' => $op->price,
                                                    'status' => 1
                                                ]);
                                            }
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                return back()->with('success', 'Sports Odd & Match created via API');
            }
            return back()->with('alert', 'API not worked.');
        } catch (\Exception $e) {
            return back()->with('alert', 'Request quota has been reached. See usage plans at https://the-odds-api.com');
        }
    }

    public function apiCatEvent()
    {
        try{
            $getSports = OddsApi::getSports();

            Category::truncate();
            foreach (collect($getSports)->groupBy('group') as $key => $data) {
                Category::create([
                    'name' => $key,
                    'slug' => Str::slug($key)
                ]);
            }
            
            Event::truncate();
            foreach (Category::whereStatus(1)->get() as $key => $data) {
                $sub = collect($getSports)->where('group', $data->name);
                foreach ($sub as $val) {
                    if ($val->active == true) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }
                    Event::create([
                        'cat_id' => $data->id,
                        'name' => $val->title,
                        'key' => $val->key,
                        'status' => $status,
                        'slug' => Str::slug($val->description),
                    ]);
                }
            }

            return back()->with('success', 'Category & Events created via API');

        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }
}
