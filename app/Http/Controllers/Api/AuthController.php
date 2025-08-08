<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\PasswordReset as PS;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'validator_errors' => $validator->errors()]);
        }

        $general = General::first();

        if ($general->emailver == 1) {
            $email_verify = 1;
        } else {
            $email_verify = 0;
        }

        $data = $request->all();
        $data['emailv'] = $email_verify;
        $data['tfver'] = 0;
        $data['balance'] = 0;
        $data['tfver'] = 0;
        $data['balance'] = 0;
        $data['password'] = Hash::make($request['password']);
        $data['referral_token'] = uniqid();
        $data['ref_id'] = isset($request['ref_id']) ? $request['ref_id'] : null;

        $user = User::create($data);

        if ($user) {
            // return response()->json(['message' => 'Registration Successfully', 'data' => $user]);

            if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
                $user = Auth::user();
                $token = $user->createToken('usertoken')->accessToken;
    
                return response()->json(['login' => true, 'token' => $token, 'data' => $user]);
            } else {
                return response()->json(['login' => false, 'message' => 'whoops! email and password is invalid'], 401);
            }
        }

        return response()->json(['message' => 'Registration Fail!'], 500);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fails', 'validator_errors' => $validator->errors()]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('usertoken')->accessToken;

            return response()->json(['login' => true, 'token' => $token, 'data' => $user]);
        } else {
            return response()->json(['login' => false, 'message' => 'whoops! email and password is invalid'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        if (Auth::user()->tauth == 1) {
            $user['tfver'] = 1;
        } else {
            $user['tfver'] = 0;
        }
        $user->save();
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    public function sendResetPassMail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'resetEmail' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fails', 'validator_errors' => $validator->errors()]);
        }

        $user = User::where('email', $request->resetEmail)->first();
        if ($user == null){
            return back()->with('alert', 'Email Not Available');
        }else{
            $code = Str::random(8);
            $message = 'Use This Link to Reset Password: '.$code;
            $exist = DB::table('password_resets')->where('email', $user->email)->where('status', 0)->where('created_at','<=',Carbon::now())->latest()->first();

            if($exist){
                $oneMin = Carbon::now()->addMinute(1);
                $dif = Carbon::parse($exist->created_at)->diffInMinutes($oneMin);
                if($dif < 2){
                    $secDif = 120 - intval(Carbon::parse($exist->created_at)->diffInSeconds($oneMin));
                    return response()->json([
                        'success' => true,
                        'message' => 'Plesae request again after '.$secDif.' seconds.'
                    ], 200);
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

            return response()->json([
                'success' => true,
                'message' => 'Password Reset Email Sent Successfully'
            ], 200);

        }
    }

    public function resetPasswordForm(Request $request) {
        $code = $request->code;
        $ps = PS::where('token', $code)->first();

        if ($ps == null) {
            return response()->json([
                'success' => false,
                'message' => 'Code not matched.'
            ], 200);
        } else {
            if ($ps->status == 0) {
                $emp = User::where('email', $ps->email)->first();
                $data['email'] = $emp->email;
                $data['code'] = $code;

                $emp->password = Hash::make('12345678');
                $emp->save();


                $userIpInfo = getIpInfo();
                $userBrowserInfo = osBrowser();
                send_email($emp, 'PASS_RESET_CODE', [
                    'code' => '12345678',
                    'operating_system' => @$userBrowserInfo['os_platform'],
                    'browser' => @$userBrowserInfo['browser'],
                    'ip' => @$userIpInfo['ip'],
                    'time' => @$userIpInfo['time']
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Password changed successfully and your default password is 12345678. Please change your password after login.'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Code time expired.'
                ], 200);
            }
        }
    }

    public function resetPassword(Request $request) {
        $messages = [
            'password_confirmation.confirmed' => 'Password does not match'
        ];

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'fails', 'validator_errors' => $validator->errors()]);
        }

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

            return response()->json([
                'success' => true,
                'message' => 'Password Reset Successfully'
            ], 500);
        }
    }
}
