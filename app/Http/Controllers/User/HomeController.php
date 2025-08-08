<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\PaymentGateway;
use App\Models\WithdrawLog;
use App\Models\Transaction;
use App\Models\Matche;
use App\Models\BetInvest;
use Carbon\Carbon;
use App\Lib\GoogleAuthenticator;
use App\Models\BetOption;
use App\Models\Event;
use App\Models\Game;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $now = Carbon::now();
        $today = Carbon::today();

        $data['page_title'] = "Dashboard";
        $data['matches'] = Matche::whereStatus(1)->where('status', '!=', 2)->where('start_date', '<=', $now)->where('end_date', '>=', $now)->latest()->limit(10)
            ->whereHas('questions', function ($q) {
                $q->whereStatus(1)->where('end_time', '>=', Carbon::now());
            })->whereHas('questions.options', function ($q) {
                $q->whereStatus(1);
            })
            ->get();
        $data['finish_matche'] = Matche::whereDate('end_date', '<', $now)->latest()->limit(10)->get();
        $data['up_com_matche'] = Matche::whereStatus(1)->where('start_date','>=', $now)->latest()->limit(5)->get();
        $data['total_withdraw'] = WithdrawLog::where('user_id', \auth()->id())->where('status', 1)->sum('amount');

        $data['totalPrediction'] = BetInvest::where('user_id', \auth()->id())->sum('invest_amount');
        $data['invest_turnament'] = BetInvest::where('user_id', \auth()->id())->where('status', 1)->sum('invest_amount');
        $data['win_turnament'] = BetInvest::where('user_id', \auth()->id())->where('status', 1)->sum('return_amount');

        // Chart Data start
        $bet_in = BetInvest::whereUserId(\auth()->id())
            ->where('status','1')
            ->whereYear('created_at', date('Y'))
            ->select(DB::raw("(COUNT(*)) as count"), DB::raw("MONTH(created_at) as month_name"))
            ->groupBy('month_name')
            ->get()
            ->toArray();

        foreach(range(1,12) as $item){
            $ar_search = array_search($item,array_column($bet_in, 'month_name'));
            if($ar_search === false){
                array_push($bet_in,[
                    'count' => 0,
                    'month_name' => $item
                ]);
            }
        }
        usort($bet_in, function ($item1, $item2) {
            return $item1['month_name'] <=> $item2['month_name'];
        });
        $chart_value_monthwise = [];
        foreach($bet_in as $val){
            array_push($chart_value_monthwise, $val['count']);
        }
        
        $data['chart_value_monthwise'] = $chart_value_monthwise;
        // Chart Data End
      
        return view('user.home', $data);
    }

    public function myPredictindex()
    {
        $data['page_title'] = "Bet Log";
        $data['logs'] = BetInvest::with('match', 'user', 'ques', 'betoption')->whereUser_id(Auth::id())->latest()->paginate(20);
        return view('user.bet-log', $data);
    }

    public function profileIndex()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view('user.profile.myprofile', $data);
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'country' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:1024'
        ]);
        try {
            if ($request->file('image')) {
                @unlink('public/images/user/' . Auth::user()->image);
                $fileName = uploadImage($request->file('image'), 'images/user');
            } else {
                $fileName = Auth::user()->image;
            }

            Auth::user()->update([
                'image' => $fileName,
                'name' => $request->name,
                'gender' => $request->gender,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'city' => $request->city,
                'country' => $request->country,
            ]);
            return back()->with('success', 'Profile Update Successfully.');
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function passwordIndex()
    {
        $data['page_title'] = "Change password";
        $data['user'] = Auth::user();
        return view('user.profile.mypassword', $data);
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
        try {
            $c_password = Auth::user()->password;
            $c_id = Auth::user()->id;
            $user = User::findOrFail($c_id);
            if (Hash::check($request->current_password, $c_password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();

                return back()->with('success', 'Password Changes Successfully.');
            } else {
                return back()->with('alert', 'Current Password Not Match');
            }
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function withdrawIndex()
    {
        $data['page_title'] = "Withdraw-Methods";
        $data['gateways'] = WithdrawMethod::where('status', 1)->get();
        return view('user.withdraw.methods', $data);
    }

    public function withdrawLog()
    {
        $data['page_title'] = "Withdraw-log";
        $data['withdraw'] = WithdrawLog::where('user_id', \auth()->id())->latest('updated_at')->paginate();
        $data['gateways'] = PaymentGateway::where('status', 1)->get();
        return view('user.withdraw.log', $data);
    }

    public function withdrawPreview(Request $request)
    {
        $this->validate($request, [
            'gateway' => 'required',
            'amount' => 'required|numeric|min:1'
        ]);

        try {
            $amount = $request->amount;
            $method = WithdrawMethod::findOrFail($request->gateway);
            $charge = ((floatval($method->chargepc) * floatval($amount)) / 100) + $method->chargefx;
            $total = floatval($charge) + floatval($amount);

            if (($request->amount >= $method->min_amo) && ($request->amount <= $method->max_amo)) {
                if ($total <= Auth::user()->balance) {
                    $page_title = 'Preview';
                    $data['gateways'] = PaymentGateway::where('status', 1)->get();
                    return view('user.withdraw.preview', $data, compact('method', 'amount', 'page_title'));
                }
                return redirect()->back()->with('alert', 'Insufficient balance');
            } else {
                return redirect()->back()->with('alert', 'Please follow withdraw limit');
            }
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function storeWithdraw(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:0',
            'method_id' => 'required',
        ]);
        try {
            $amount = $request->amount;
            $method = WithdrawMethod::findOrFail($request->method_id);
            $charge = ((floatval($method->chargepc) * floatval($amount)) / 100) + floatval($method->chargefx);
            $total = floatval($charge) + floatval($amount);

            $user = Auth::user();
            if (($total <= $user->balance) && ($request->amount >= $method->min_amo) && ($request->amount <= $method->max_amo)) {
                $new_balance = floatval($user->balance) - floatval($total);
                createTransaction("Withdraw via " . $method->name, $total, $user->balance, $new_balance, 3);
                $user->balance = $new_balance;
                $user->update();
                $withdraw = WithdrawLog::create([
                    'amount' => $amount,
                    'charge' => $charge,
                    'method_name' => $method->name,
                    'processing_time' => $method->processing_day,
                    'detail' => $request->detail,
                    'method_rate' => $method->rate,
                    'method_cur' => $method->currency,
                    'withdraw_id' => $request->method_id,
                    'trx' => getTrx(),
                    'user_id' => $user->id,
                    'status' => 0,
                ]);

                $adminNotification = new Notification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'New withdraw request from ' . $user->name;
                $adminNotification->click_url = urlPath('admin.withdraw.detail', $withdraw->id);
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'New withdraw request from ' . $user->name;
                $adminNotification->click_url = urlPath('admin.withdraw.detail', $withdraw->id);
                $adminNotification->save();

                $general = General::first();
                $shortCodes = [
                    'trx' => $withdraw->trx,
                    'amount' => $withdraw->amount,
                    'charge' => $withdraw->charge,
                    'currency' => $general->currency,
                    'rate' => $withdraw->method_rate,
                    'method_name' => $withdraw->method_name,
                    'method_currency' => $withdraw->method_cur,
                    'post_balance' => $new_balance,
                    'method_amount' => $total,
                    'delay' => $method->processing_day,
                ];
                @send_email($user, 'WITHDRAW_REQUEST', $shortCodes);
                return redirect()->route('home')->with('success', 'Withdraw Request Success, Wait for processing day');
            } else {
                return redirect()->route('user.withdraw.method')->with('alert', 'Insufficient balance');
            }
        } catch (\Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }

    public function transactionLog()
    {
        $data['page_title'] = "Transaction Log";
        $data['trans'] = Transaction::where('user_id', \auth()->id())->latest('updated_at')->paginate();
        $data['gateways'] = PaymentGateway::where('status', 1)->get();
        return view('user.trans-log', $data);
    }

    public function searchTrans(Request $request)
    {
        $trans = Transaction::query();
        if (!is_null($request->trans_id)) {
            $trans->where("trans_id", "LIKE", "%{$request->trans_id}%");
        }
        if (!is_null($request->type)) {
            switch ($request->type) {
                case "Deposit":
                    $trans->where('status', 1);
                    break;
                case "Transfer":
                    $trans->where('status', 2);
                    break;
                case "Predict":
                    $trans->where('status', 4);
                    break;
                case "Withdraw":
                    $trans->where('status', 3);
                    break;
                case "Referral":
                    $trans->where('status', 5);
                    break;
                case "Game":
                    $trans->where('status', 10);
                    break;
                default:
                    $trans->whereIn('status', [1, 2, 3, 4, 5, 10]);
            }
        }
        $data['page_title'] = "Searched Transaction Log";
        $data['trans'] = $trans->where('user_id', \auth()->id())->latest('updated_at')->paginate(50);
        $data['gateways'] = PaymentGateway::where('status', 1)->get();
        return view('user.trans-log', $data);
    }

    public function twoFactorIndex()
    {
        $data['page_title'] = "Two Factor";
        $gnl = General::first();
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $explode = explode('@', Auth::user()->email);
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($explode[0] . '@' . $gnl->web_name, $secret);
        $prevcode = Auth::user()->secretcode;
        $prevqr = $ga->getQRCodeGoogleUrl($explode[0] . '@' . $gnl->web_name, $prevcode);
        $data['gateways'] = PaymentGateway::where('status', 1)->get();

        return view('frontend.goauth.create', $data, compact('secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = User::find(Auth::id());
        $ga = new GoogleAuthenticator();
        $secret = $user->secretcode;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;
        if ($oneCode == $userCode) {
            $user = User::find(Auth::id());
            $user['tauth'] = 0;
            $user['tfver'] = 0;
            $user['secretcode'] = '0';
            $user->save();
            $userIpInfo = getIpInfo();
            $userBrowser = osBrowser();
            @send_email($user, '2FA_DISABLE', [
                'operating_system' => @$userBrowser['os_platform'],
                'browser' => @$userBrowser['browser'],
                'ip' => @$userIpInfo['ip'],
                'time' => @$userIpInfo['time']
            ]);

            return back()->with('success', 'Two Factor Authenticator Disable Successfully');
        } else {
            return back()->with('alert', 'Wrong Verification Code');
        }
    }

    public function create2fa(Request $request)
    {
        $user = User::find(Auth::id());
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;
        if ($oneCode == $userCode) {
            $user['secretcode'] = $request->key;
            $user['tauth'] = 1;
            $user['tfver'] = 0;
            $user->save();
            $userIpInfo = getIpInfo();
            $userBrowser = osBrowser();
            @send_email($user, '2FA_ENABLE', [
                'operating_system' => @$userBrowser['os_platform'],
                'browser' => @$userBrowser['browser'],
                'ip' => @$userIpInfo['ip'],
                'time' => @$userIpInfo['time']
            ]);

            return back()->with('success', 'Google Authenticator Enabeled Successfully');
        } else {
            return back()->with('alert', 'Wrong Verification Code');
        }
    }

    public function prediction(Request $request)
    {
        $general = General::first();
        $this->validate($request, [
            'invest_amount' => 'required|numeric',
            'return_amount' => 'required|numeric'
        ]);

        $predictOption = BetOption::find($request->betoption_id);

        $user = User::find(Auth::id());
        $invseterBal = $user->balance;

        if (Carbon::parse($predictOption->question->end_time) > Carbon::now()) {
            if ($user->balance >= $request->invest_amount) {

                if ($predictOption->min_amo <= $request->invest_amount) {

                    $predictIn = BetInvest::where('user_id', Auth::id())->where('betoption_id', $predictOption->id)->where('betquestion_id', $predictOption->question->id)->where('match_id', $predictOption->match->id)->sum('invest_amount');
                    $lastPredictionIn = BetInvest::where('user_id', Auth::id())->where('betoption_id', $predictOption->id)->where('betquestion_id', $predictOption->question->id)->where('match_id', $predictOption->match->id)->latest()->first();

                    if ($lastPredictionIn && Carbon::parse($lastPredictionIn->created_at)->addSeconds(15) > Carbon::now()) {
                        $time = Carbon::parse($lastPredictionIn->created_at)->addSeconds(15);
                        $delay = $time->diffInSeconds(Carbon::now());
                        $delay = gmdate('i:s', $delay);
                        return back()->with('alert', 'You can next predict after ' . $delay . ' seconds in ' . $predictOption->option_name);
                    }

                    if (($predictIn + $request->invest_amount) > $predictOption->bet_limit) {
                        return back()->with('alert', 'Your Prediction limit over in' . ($predictOption->option_name));
                    }


                    $data['user_id'] = Auth::id();
                    $data['betoption_id'] = $request->betoption_id;
                    $data['betquestion_id'] = $request->betquestion_id;
                    $data['match_id'] = $request->match_id;
                    $data['invest_amount'] = $request->invest_amount;

                    $finalRatioReturnAmo = round((($request->invest_amount * $predictOption->ratio2) / $predictOption->ratio1), 2);

                    $data['return_amount'] = $finalRatioReturnAmo;
                    $data['remaining_balance'] = $invseterBal;
                    $data['ratio'] = "$predictOption->ratio1 X $predictOption->ratio2";

                    $inverstInfo = BetInvest::create($data);
                    $trxQ = $inverstInfo->ques->question;

                    $newBalance = floatval($user->balance) - round($request->invest_amount, 2);


                    $mm = Matche::whereId($request->match_id)->first();
                    $trx = createTransaction('Predict in ' . $mm->name . ' -' . $trxQ . ' => ' . $predictOption->option_name, round($request->invest_amount, 2), $user->balance, $newBalance, 4, null, '-');

                    $user->balance -= round($request->invest_amount, 2);
                    $user->save();

                    $match_name = $inverstInfo->match->team_1 .' VS '. $inverstInfo->match->team_2;

                    $shortCodes = [
                        'trx' => $trx->trans_id,
                        'invest_amount' => $inverstInfo->invest_amount,
                        'return_amount' => $inverstInfo->return_amount,
                        'currency' => $general->currency,
                        'post_balance' => $newBalance,
                        'match' => $match_name,
                        'question' => $inverstInfo->ques->question,
                        'option' => $inverstInfo->betoption->option_name,
                    ];
                    @send_email($user, 'BET_PLACED', $shortCodes);

                    return back()->withInput()->with('success', 'Successfully Prediction in ' . $predictOption->option_name);
                } else {
                    return back()->withInput()->with('alert', 'Minimum Prediction Amount' . $predictOption->min_amo . $general->currency);
                }
            } else {
                return back()->withInput()->with('alert', 'Insufficient Balance');
            }
        } else {
            return back()->withInput()->with('alert', 'Time has been expired');
        }
    }

    public function myRef($level = 1)
    {
        $data['page_title'] = "My Referral";
        $referrals = auth()->user()->referral;
        $data['gateways'] = PaymentGateway::where('status', 1)->get();
        return view('user.ref', $data, compact('referrals'));
    }

    function compare_months($a, $b) {
        $monthA = date_parse($a);
        $monthB = date_parse($b);
        return $monthA["month"] - $monthB["month"];
    }
}
