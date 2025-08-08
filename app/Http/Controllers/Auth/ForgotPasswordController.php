<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Social;
use App\Models\ExtraPage;
use App\Models\User;
use App\Models\PasswordReset as PS;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showEmailForm() {
        $data['page_title'] = __('Forgot Password');
        return view('user.auth.passwords.email',$data);
    }

    public function sendResetPassMail(Request $request)
    {
        $this->validate($request,[
            'resetEmail' => 'required',
        ]);
        $user = User::where('email', $request->resetEmail)->first();
        if ($user == null){
            return back()->with('alert', 'Email Not Available');
        }else{
            $code = Str::random(30);
            $message = 'Use This Link to Reset Password: '.url('/').'/reset/'.$code;
            $exist = DB::table('password_resets')->where('email', $user->email)->where('status', 0)->where('created_at','<=',Carbon::now())->latest()->first();

            if($exist){
                $oneMin = Carbon::now()->addMinute(1);
                $dif = Carbon::parse($exist->created_at)->diffInMinutes($oneMin);
                if($dif < 2){
                    $secDif = 120 - intval(Carbon::parse($exist->created_at)->diffInSeconds($oneMin));
                    return back()->with('alert', __('Plesae request again after '.$secDif.' seconds.'));
                }
            }

            DB::table('password_resets')->insert(
                ['email' => $user->email, 'token' => $code, 'status' => 0, 'created_at' => date("Y-m-d h:i:s")]
            );

            $userIpInfo = getIpInfo();
            $userBrowserInfo = osBrowser();
            send_email($user, 'PASS_RESET_CODE', [
                'code' => ''.url('/').'/reset/'.$code,
                'operating_system' => @$userBrowserInfo['os_platform'],
                'browser' => @$userBrowserInfo['browser'],
                'ip' => @$userIpInfo['ip'],
                'time' => @$userIpInfo['time']
            ]);
            return back()->with('success', 'Password Reset Email Sent Successfully');
        }
    }

    public function resetPasswordForm($code) {
        $ps = PS::where('token', $code)->first();

        if ($ps == null) {
            return redirect()->route('user.showEmailForm');
        } else {
            if ($ps->status == 0) {
                $emp = User::where('email', $ps->email)->first();
                $data['email'] = $emp->email;
                $data['code'] = $code;
                return view('user.auth.passwords.reset', $data);
            } else {
                return redirect()->route('user.showEmailForm');
            }
        }
    }

    public function resetPassword(Request $request) {
        $messages = [
            'password_confirmation.confirmed' => 'Password does not match'
        ];

        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ], $messages);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $userIpInfo = getIpInfo();
            $userBrowser = osBrowser();
            send_email($user, 'PASS_RESET_DONE', [
                'operating_system' => @$userBrowser['os_platform'],
                'browser' => @$userBrowser['browser'],
                'ip' => @$userIpInfo['ip'],
                'time' => @$userIpInfo['time']
            ]);
            return redirect()->route('home')->with('success', 'Password Reset Successfully');
        }
    }
}
