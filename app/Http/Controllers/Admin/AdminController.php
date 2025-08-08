<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BetInvest;
use App\Models\Deposit;
use App\Models\DepositRequest;
use App\Models\Event;
use App\Models\General;
use App\Models\Matche;
use App\Models\Notification;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\WithdrawLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function adminIndex()
    {
        $data['page_title'] = "Dashboard";
        $data['total_user'] = User::count();
        $data['total_ver_user'] = User::where('status', 1)->count();
        $data['total_unver_user'] = User::where('emailv', 0)->count();
        $data['total_bn_user'] = User::where('status', 0)->count();
        $data['total_deposit'] = Deposit::where('status', 1)->sum('amount');
        $data['total_deposit_crg'] = Deposit::where('status', 1)->sum('charge');
        $data['total_depo_pending'] = DepositRequest::where('status', 0)->count();
        $data['total_withdraw'] = WithdrawLog::where('status', 1)->sum('amount');
        $data['total_withdraw_crg'] = WithdrawLog::where('status', 1)->sum('charge');
        $data['total_withdraw_pending'] = WithdrawLog::where('status', 0)->count();
        $now = Carbon::now();
        $todayDate = Carbon::now()->format('d M Y');
        $data['runningMatches'] = Matche::where('end_date', '>', $now)->count();
        $data['endMatches'] = Matche::where('end_date', '<', $now)->count();
        $data['runing_turnament'] = Event::whereStatus(1)->count();
        $data['pridictionInvest'] = BetInvest::where('status', '!=', 2)->sum('invest_amount');
        $data['pridictionRefund'] = BetInvest::where('status', 2)->sum('invest_amount');
        $data['pridictionReturn'] = BetInvest::where('status', 1)->sum('return_amount');
        $data['totalProfit'] = number_format(($data['pridictionInvest'] - $data['pridictionReturn']), 2);
        $data['latestUser'] = User::latest()->paginate(15);

        $trxReport['date'] = collect([]);

        $trxReport['date'] = $trxReport['date']->unique()->toArray();


        $report['months']    = collect([]);
        $report['deposit_month_amount']    = collect([]);
        $report['withdraw_month_amount']    = collect([]);

        $plusTrx = Transaction::where('type', '+')->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM(amount) as amount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')
            ->get();
        $plusTrx->map(function ($trxData) use ($report) {
            $report['months']->push($trxData->months);
        });

        $minusTrx = Transaction::where('type', '-')->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM(amount) as amount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')
            ->get();

        $minusTrx->map(function ($trxData) use ($report) {
            $report['months']->push($trxData->months);
        });

        $depositsMonth = Deposit::where('created_at', '>=', Carbon::now()->subYear())
            ->where('status', 1)
            ->selectRaw("SUM(CASE WHEN status = 1 THEN amount END) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')
            ->get();        

        $depositsMonth->map(function ($depositData) use ($report) {
            $report['months']->push($depositData->months);
            $report['deposit_month_amount']->push(getAmount($depositData->depositAmount));
        });

        $withdrawalMonth = WithdrawLog::where('created_at', '>=', Carbon::now()->subYear())->where('status', 1)
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as withdrawAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();
        $withdrawalMonth->map(function ($withdrawData) use ($report) {
            if (!in_array($withdrawData->months, $report['months']->toArray())) {
                $report['months']->push($withdrawData->months);
            }
            $report['withdraw_month_amount']->push(getAmount($withdrawData->withdrawAmount));
        });

        $months = $report['months'];

        for ($i = 0; $i < $months->count(); ++$i) {
            $monthVal = Carbon::parse($months[$i]);
            if (isset($months[$i + 1])) {
                $monthValNext = Carbon::parse($months[$i + 1]);
                if ($monthValNext < $monthVal) {
                    $temp           = $months[$i];
                    $months[$i]     = Carbon::parse($months[$i + 1])->format('F-Y');
                    $months[$i + 1] = Carbon::parse($temp)->format('F-Y');
                } else {
                    $months[$i] = Carbon::parse($months[$i])->format('F-Y');
                }
            }
        }

        $play2 = BetInvest::whereYear('created_at', date('Y'))->orderBy('created_at', 'asc')->get()->groupBy(function ($d) {
            return Carbon::parse($d->date)->format('m');
        });
        $monthly_play2 = [];
        $js2 = '';
        foreach ($play2 as $key => $value) {
            $date = date('Y') . '-' . $key . '-' . '01';
            $js2 .= collect([
                'y' => Carbon::parse($date)->format('M'),
                'a' => $value->sum('invest_amount'),
                'b' => $value->where('status', 1)->sum('return_amount'),
                'c' => $value->where('status', 2)->sum('invest_amount'),
            ])->toJson() . ',';
        }

        $monthly_play2 = '[' . $js2 . ']';

        $play3 = WithdrawMethod::with('method_log')->where('status', 1)->whereYear('created_at', '>=', Carbon::now()->subYear())->get();
        $monthly_play3 = [];
        $js3 = '';
        foreach ($play3 as $value) {
            $js3 .= collect([
                'label' => $value->name,
                'value' => $value->method_log()->sum('amount'),
            ])->toJson() . ',';
        }

        $monthly_play3 = '[' . $js3 . ']';

        return view('admin.home', $data, compact('report', 'months', 'depositsMonth', 'withdrawalMonth', 'trxReport', 'plusTrx', 'minusTrx', 'monthly_play2', 'monthly_play3', 'todayDate'));
    }

    public function transactionIndex()
    {
        $page_title = "Transaction Log";
        $trans = Transaction::latest('id')->paginate(30);
        return view('admin.trans-log', compact('trans','page_title'));
    }

    public function searchResult(Request $request)
    {
        $trans = Transaction::query();
        if (!is_null($request->trans_id)){
            $trans->where("trans_id","LIKE","%{$request->trans_id}%");
        }
        if (!is_null($request->user)){
            $u = $request->user;
            $trans->whereHas('user',function ($q) use ($u){
                $q->where('name',"LIKE","%{$u}%");
            });
        }
        if (!is_null($request->type)){
            switch ($request->type){
                case "Invest":
                    $trans->where('status', 0);
                    break;
                case "Deposit":
                    $trans->where('status', 1);
                    break;
                case "Transfer":
                    $trans->where('status', 2);
                    break;
                case "Income":
                    $trans->where('status', 4);
                    break;
                case "Withdraw":
                    $trans->where('status', 3);
                    break;
                case "Referral":
                    $trans->where('status', 5);
                    break;
                default:
                    $trans->whereIn('status', [0,1,2,3,4,5]);
            }
        }
        $trans = $trans->latest('id')->paginate(50);
        $page_title = "Transaction Log";
        return view('admin.trans-log', compact('trans','page_title'));
    }

    public function changeProfile()
    {
        $data['page_title'] = "Profile Settings";
        return view('admin.profile', $data);
    }

    public function userUpdate(Request $request ,$id)
    {
        $this->validate($request,[
            'name' => 'required',
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->back()->with('success','Successfully Updated');
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'sometimes|mimes:jpeg,png,bmp,gif,svg,webp|max:1024',
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($request->image) {
            $size = [120, 120];
        }
        if ($request->file('image')) {
            @unlink('public/images/admin/'. $request->image);
            $fileName = uploadImage($request->file('image'), 'images/admin', null, null, $size);
        } else {
            $fileName = $request->image;
        }

        $user = auth()->guard('admin')->user();
        $user->image = $fileName;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Profile update successful');
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin')->with('success', 'Logout successfully');
    }

    public function referralIndex()
    {
        $data['page_title'] = "Referral Commission Settings";
        $ref = Referral::all();
        $lastRef = Referral::orderBy('id', 'desc')->first();
        return view('admin.referral.index', $data, compact('ref', 'lastRef'));
    }

    public function referralStore(Request $request)
    {
        if (count($request->percentage) == 0) {
            return back()->with('alert', 'Percentage field is required');
        }
        try {
            foreach ($request->percentage as $data) {
                if (!is_null($data)) {
                    if (!is_numeric($data)) return back()->with('alert', 'Please insert numeric value.');
                }
            }
            Referral::truncate();
            foreach ($request->percentage as $data) {
                Referral::create([
                    'percentage' => $data
                ]);
            }
            return back()->with('success', 'Referral Percentage Commission generated.');
        } catch (\Exception $e) {
            return back()->with('success', 'Referral Percentage Commission generated.');
        }
    }

    public function usersIndex()
    {
        $data['page_title'] = "Manage Users";
        $general = General::first();
        $data['user'] = User::latest('id')->paginate($general->paginate);
        return view('admin.user.index', $data);
    }

    public function usersActiveIndex()
    {
        $data['page_title'] = "Active Users";
        $general = General::first();
        $user = User::whereStatus(1)->latest('id')->paginate($general->paginate);
        return view('admin.user.index', $data, compact('user'));
    }

    public function usersBanndedIndex()
    {
        $data['page_title'] = "Banned Users";
        $general = General::first();
        $user = User::whereStatus(0)->latest('id')->paginate($general->paginate);
        return view('admin.user.index', $data, compact('user'));
    }

    public function usersUnverifiedIndex()
    {
        $data['page_title'] = "Email Unverified Users";
        $general = General::first();
        $user = User::where('emailv', 0)->latest('id')->paginate($general->paginate);
        return view('admin.user.index', $data, compact('user'));
    }

    public function userSearch(Request $request)
    {
        $data['page_title'] = "Manage Users";
        $general = General::first();
        $user = User::where('name', 'LIKE', "%{$request->name}%")->paginate($general->paginate);
        return view('admin.user.index', $data, compact('user','general'));
    }

    public function userSearchEmail(Request $request)
    {
        $data['page_title'] = "Manage Users";
        $general = General::first();
        $user = User::where('email', 'LIKE', "%{$request->email}%")->paginate($general->paginate);
        return view('admin.user.index', $data, compact('user','general'));
    }

    public function indexUserDetail($id)
    {
        $data['page_title'] = "User Detail";
        $data['user'] = User::findOrFail($id);
        return view('admin.user.view', $data);
    }

    public function passwordSetting($id)
    {
        $user = User::findorFail($id);
        $data['page_title'] = $user->name . " Password Setting";
        return view('admin.user.password', $data, compact('user'));
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::findorFail($id);

        $request->validate([
            'new_password' => 'required|min:5',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $password = $request->new_password;
        $passwordConf = $request->password_confirmation;

        if ($password != $passwordConf) {
            session()->flash('danger', 'Password Do not match!!');
        } elseif ($password == $passwordConf) {
            $user->password = bcrypt($password);
            $user->save();
            session()->flash('success', 'Password Changed Successfully!!');
        }
        return back();
    }

    public function indexUserBalance($id)
    {
        $user = User::findOrFail($id);
        $data['page_title'] = $user->username . " Manage Balance";
        return view('admin.user.balance', $data, compact('user'));
    }

    public function indexBalanceUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:0',
            'operation' => 'required',
        ]);
        $user = User::find($id);
        $general = General::first();
        if ($user instanceof User) {
            if ($request->operation == 1) {
                $new_balance = $user->balance + $request->amount;
                createTransaction("Balance added via admin", $request->amount, $user->balance, $new_balance, 1, $user->id);
                $user->balance = $new_balance;
                $user->update();
                if (!is_null($request->message)) {
                    $shortCodes = [
                        'amount' => $request->amount,
                        'currency' => $general->currency,
                        'post_balance' => $new_balance,
                        'post_message' => $request->message,
                    ];
                    send_email($user, "BAL_ADD", $shortCodes);
                }
                return back()->with('success', 'Balance Add Successful');
            } else {
                if ($user->balance >= $request->amount) {
                    $new_balance = $user->balance - $request->amount;
                    createTransaction("Balance deduct via admin", $request->amount, $user->balance, $new_balance, 1, $user->id);
                    $user->balance = $new_balance;
                    $user->update();
                    if (!is_null($request->message)) {
                        $shortCodes = [
                            'amount' => $request->amount,
                            'currency' => $general->currency,
                            'post_balance' => $new_balance,
                            'post_message' => $request->message,
                        ];
                        send_email($user, "BAL_SUB", $shortCodes);
                    }
                    return back()->with('success', 'Balance Subtract Successful');
                }
                return back()->with('alert', 'Insufficient Balance.');
            }
        }
        return back()->with('alert', 'User not found.');
    }

    public function userSendMail($id)
    {
        $user = User::findOrFail($id);
        $data['page_title'] = $user->name . " Send Email";
        return view('admin.user.send_mail', $data, compact('user'));
    }

    public function userSendMailUser(Request $request)
    {
        $this->validate($request, [
            'emailto' => 'required|email',
            'receiver' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $to = $request->emailto;
        $name = $request->receiver;
        $subject = $request->subject;
        $message = $request->message;
        send_email($to, $name, $subject, $message);
        return back()->with('success', 'Mail Sent Successfully!');
    }

    public function predictions($id)
    {
        $user = User::findorFail($id);
        $page_title = "$user->name - All Prediction";
        $general = General::first();
        $pedict_logs = BetInvest::whereUser_id($user->id)->latest()->paginate($general->paginate);
        return view('admin.user.predictions', compact('pedict_logs', 'page_title', 'user'));
    }

    public function paymentLog($id)
    {
        $user = User::findorFail($id);
        $page_title = "$user->name - Payment Log";
        $general = General::first();
        $payment_logs = Deposit::whereUser_id($id)->whereIn('status', [2, -2, 1])->latest()->paginate($general->paginate);
        return view('admin.user.payment_log', compact('payment_logs', 'page_title', 'user'));
    }
    public function withdrawLog($id)
    {
        $user = User::findorFail($id);
        $page_title = "$user->name -  withdraw Log";
        $general = General::first();
        $withdraw_logs = WithdrawLog::whereUser_id($user->id)->where('status', '!=', 0)->latest()->paginate($general->paginate);
        return view('admin.user.withdraw_log', compact('withdraw_logs', 'page_title', 'user'));
    }

    public function transactionLog($id)
    {
        $user = User::findorFail($id);
        $page_title = "$user->name - All Transaction";
        $general = General::first();
        $trx = Transaction::whereUser_id($user->id)->latest()->paginate($general->paginate);
        return view('admin.user.transaction', compact('trx', 'page_title', 'user'));
    }
    
    public function notifications(){
        $page_title = 'Notifications';
        $general = General::first();
        $notifications = Notification::orderBy('id','desc')->with('user')->paginate($general->paginate);
        return view('admin.notifications',compact('page_title','notifications'));
    }

    public function notificationRead($id){
        $notification = Notification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }

    public function readAll(){
        Notification::where('read_status',0)->update([
            'read_status' => 1
        ]);
        return back()->with('success', 'Notifications read successfully');
    }
}
