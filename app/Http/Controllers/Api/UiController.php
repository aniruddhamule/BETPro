<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\BlogCategory;
use App\Models\Event;
use App\Models\General;
use App\Models\Language;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SmtpMail;
use App\Models\BetOption;
use App\Models\Category;
use App\Models\Slider;
use App\Services\OddsApi;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Validator;

class UiController extends Controller
{
    public function index()
    {

        $now = Carbon::now();
        $today = Carbon::today();
        $general = General::first();
        $testimonial = Testimonial::get();
        $data['testimonial'] = $testimonial->map(function($q, $key) {
            $q['image_url'] = asset('public/images/testimonial/'.$q->image);	
            return $q;
        });
        $service = Service::get();
        $data['service'] = $service->map(function($q, $key) {
            $q['image_url'] = asset('public/images/service/'.$q->image);	
            return $q;
        });
        $data['social'] = Social::get();
        $data['faqs'] = Faq::get();
        $slider = Slider::whereStatus(1)->get();
        $data['slider'] = $slider->map(function($q, $key) {
            $q['image_url'] = asset('public/images/slider/'.$q->image);	
            return $q;
        });
        // $data['extra_page'] = ExtraPage::get();
        $news = Blog::latest()->limit(3)->get();
        $data['news'] = $news->map(function($q, $key) {
            $q['image_url'] = asset('public/images/blog/'.$q->image);	
            return $q;
        });
        $data['sub_category'] = Event::with('cat')->whereStatus(1)->get();
        $data['category'] = Category::whereStatus(1)
            ->whereHas('event', function ($q) {
                $q->whereStatus(1);
            })->whereHas('matches', function ($q) {
                $q->whereStatus(1);
            })
            ->get();
        // $data['matches'] = Matche::whereStatus(1)->whereDate('start_date', $now->today())->where('end_date', '>=', $now)->latest()
        //     ->whereHas('questions', function ($q) {
        //         $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
        //     })->whereHas('questions.options', function ($q) {
        //         $q->whereStatus(1);
        //     })->paginate($general->paginate);
            
        $matches = Matche::with('cat')->with('event')->with('questions')->with('options')->whereStatus(1)->where('status', '!=', 2)->where('start_date', '<=', $now)->where('end_date', '>=', $now)->latest()
        ->whereHas('questions', function ($q) {
            $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
        })->whereHas('questions.options', function ($q) {
            $q->whereStatus(1);
        })
        ->paginate($general->paginate);
        
        $data['matches'] = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });

        $up_com_matche = Matche::with('cat')->with('event')->with('questions')->with('options')->whereStatus(1)->whereDate('start_date', '>=', $now)->latest()->paginate($general->paginate);
        $data['up_com_matche'] = $up_com_matche->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });
        
        $date = Carbon::today()->subDays(7);

        $data['weeklyLeader'] = BetInvest::with('user')->where('created_at', '>=', $date)->where('status', '!=', 2)->groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as total_predictions'),  DB::raw('sum(invest_amount) as investAmount'))
            ->limit(5)
            ->orderBy('investAmount', 'desc')
            ->get();

        $data['leader'] = BetInvest::with('user')->where('status', '!=', 2)->groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as total_predictions'),  DB::raw('sum(invest_amount) as investAmount'))
            ->orderBy('investAmount', 'desc')
            ->limit(5)
            ->get();


        $data['success'] = true;
        return response()->json($data);
    }

    public function allEvents()
    {
        $now = Carbon::now();
        $general = General::first();
        $matches = Matche::with('cat')->with('event')->with('questions')->with('options')->whereStatus(1)->where('status', '!=', 2)
            ->where('end_date', '>', $now)->orderBy('start_date', 'asc')->limit(10)
            ->whereHas('questions', function ($q) {
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            })->paginate($general->paginate);

        $data['matches'] = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });

        $data['success'] = true;
        return response()->json($data);
    }

    public function allFinished()
    {
        $now = Carbon::now();
        $general = General::first();
        $matches = Matche::with('cat')->with('event')->with('questions')->with('options')->where('end_date', '<', $now)->orderBy('start_date', 'asc')->paginate($general->paginate);
        $data['matches'] = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });
        $data['success'] = true;
        return response()->json($data);
    }

    public function allCancelled()
    {
        $now = Carbon::now();
        $general = General::first();
        $matches = Matche::with('cat')->with('event')->with('questions')->with('options')->whereStatus(2)->where('end_date', '<', $now)->orderBy('start_date', 'asc')->paginate($general->paginate);
        $data['matches'] = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });
        
        $data['success'] = true;
        return response()->json($data);
    }

    public function allLiveMatch()
    {
        $now = Carbon::now();
        $general = General::first();
        $matches = Matche::with('cat')->with('event')->with('event')->with('questions')->with('options')->whereStatus(1)->where('status', '!=', 2)
            ->where('start_date', '<=', $now)->where('end_date', '>=', $now)->latest()->limit(10)
            ->whereHas('questions', function ($q) {
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            })->whereHas('questions.options', function ($q) {
                $q->whereStatus(1);
            })
            ->paginate($general->paginate);

        $matches = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });

        $data['success'] = true;
        return response()->json($data);
    }

    public function allUpComMatch()
    {
        $now = Carbon::now();
        $general = General::first();
        $matches = Matche::with('cat')->with('event')->with('questions')->with('options')->whereStatus(1)->where('start_date', '>=', $now)->latest()->paginate($general->paginate);
        $data['matches'] = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });
        $data['success'] = true;
        return response()->json($data);
    }

    public function policyIndex(Request $request)
    {
        $slug = $request->slug;
        $now = Carbon::now();
        $policy = ExtraPage::whereSlug($slug)->firstOrFail();
        $data['page_title'] = "$policy->title";
        $data['policy'] = $policy;
        $data['success'] = true;
        return response()->json($data);
    }

    public function tournament($cat_slug = null, $slug = null)
    {
        $now = Carbon::now();
        $general = General::first();
        $tournament = Event::with('cat')->whereSlug($slug)->first();
        $data['page_title'] = "$tournament->name";
        $matches = Matche::with('cat')->with('event')->with('questions')->with('options')->where('event_id', $tournament->id)->whereStatus(1)->where('status', '!=', 2)->where('start_date', '>=', $now)->latest()->limit(10)
            ->whereHas('questions', function ($q) {
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            })
            ->paginate($general->paginate);
        $data['matches'] = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });
        $data['users'] = User::count();
        $data['totalPrediction'] = BetInvest::count();


        $data['success'] = true;
        return response()->json($data);
    }

    public function categories($slug)
    {
        $now = Carbon::now();
        $general = General::first();
        $category = Category::whereSlug($slug)->where('status', 1)->firstOrFail();
        $data['page_title'] = "$category->name";
        $data['tournament'] = Event::with('cat')->where('cat_id', $category->id)->where('status', 1)->get();
        $matches = Matche::with('cat')->with('event')->with('questions')->with('options')->where('cat_id', $category->id)->whereStatus(1)->where('end_date', '>', $now)->orderBy('start_date', 'asc')
            ->whereHas('questions', function ($q) {
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            })
            ->paginate($general->paginate);

        $data['matches'] = $matches->map(function($q, $key) {
            $q['image_url_team_1'] = asset('public/images/match/'.$q->team_1_image);	
            $q['image_url_team_2'] = asset('public/images/match/'.$q->team_2_image);	
            return $q;
        });
        $data['users'] = User::count();
        $data['totalPrediction'] = BetInvest::count();
        $data['success'] = true;
        return response()->json($data);
    }

    public function aboutIndex()
    {
        $data['page_title'] = "About Us";
        $data['social'] = Social::get();
        // $data['extra_page'] = ExtraPage::get();
        $data['success'] = true;
        return response()->json($data);
    }

    public function newsIndex()
    {
        $data['page_title'] = "News";
        $news = Blog::get();
        $data['news'] = $news->map(function($q, $key) {
            $q['image_url'] = asset('public/images/blog/'.$q->image);	
            return $q;
        });
        $data['social'] = Social::get();
        // $data['extra_page'] = ExtraPage::get();
        $data['success'] = true;
        return response()->json($data);
    }

    public function newsDetails(Request $request)
    {
        $data['page_title'] = "News Details";
        $news = Blog::findOrFail($request->id);
        $recent_post = Blog::latest('created_at')->take(3)->get();
        $data['recent_post'] = $recent_post->map(function($q, $key) {
            $q['image_url'] = asset('public/images/blog/'.$q->image);	
            return $q;
        });
        $data['news'] = $news;
        $data['success'] = true;
        return response()->json($data);
    }

    public function contactIndex()
    {
        $data['page_title'] = "Contact Us";
        $data['social'] = Social::get();
        // $data['extra_page'] = ExtraPage::get();
        $data['success'] = true;
        return response()->json($data);
    }

    public function contactSend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:91',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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

            @send_email($user, 'contact-mail');

            return response()->json([
                'success' => true,
                'message' => __('Mail has been sent')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function authorization()
    {
        $data['page_title'] = "Verification";
        if (Auth::user() && Auth::user()->tfver == '1' && Auth::user()->status == '1' && Auth::user()->emailv == 1 && Auth::user()->smsv == 1) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function sendemailver()
    {
        try {
            $user = Auth::user();
            $chktm = $user->vsent + 1000;
            if ($chktm > time()) {
                $delay = $chktm - time();
                return response()->json([
                    'success' => false,
                    'message' => 'Please Try after ' . $delay . ' Seconds'
                ]);
            } else {
                $code = substr(rand(), 0, 6);
                $user['vercode'] = $code;
                $user['vsent'] = time();
                $user->save();
                $shortCodes = [
                    'code' => $code
                ];
                @send_email($user, 'EVER_CODE', $shortCodes);
                return response()->json([
                    'success' => true,
                    'message' => 'Email verification code sent successfully'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function emailverify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = Auth::user();

            $code = $request->code;
            if ($user->vercode == $code) {
                $user['emailv'] = 0;
                $user['vercode'] = str::random(10);
                $user['vsent'] = 0;
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Email Verified'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Wrong Verification Code'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function verify2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::find(Auth::id());

            $ga = new GoogleAuthenticator();

            $secret = $user->secretcode;
            $oneCode = $ga->getCode($secret);
            $userCode = $request->code;

            if ($oneCode == $userCode) {
                $user['tfver'] = 0;
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Verification Successful.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong Verification Code'
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }


    public function subscriberStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            Subscriber::create([
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscribe Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong.'
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $data['page_title'] = "News";
        $search = $request->input('title');
        $news = blog::where('title', 'LIKE', '%' . $search . '%')->paginate(36);
        $data['news'] = $news->map(function($q, $key) {
            $q['image_url'] = asset('public/images/blog/'.$q->image);	
            return $q;
        });
        $data['success'] = true;
        return response()->json($data);
    }
}
