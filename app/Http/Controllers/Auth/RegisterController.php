<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Social;
use App\Models\ExtraPage;
use App\Models\General;
use App\Models\Notification;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;
    
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    
    protected function create(array $data)
    {
        $general = General::first();

        if ($general->emailver == 1) {
            $email_verify = 1;
        } else {
            $email_verify = 0;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'emailv' => $email_verify,
            'tfver' => 0,
            'balance' => 0,
            'password' => Hash::make($data['password']),
            'referral_token' => uniqid(),
            'ref_id' => isset($data['ref_id']) ? $data['ref_id'] : null,
        ]);

    }

    public function showRegistrationForm($referral_token = null)
    {
        if($referral_token){
            $data['refName'] = User::where('referral_token',$referral_token)->first();
        }
        $data['page_title'] = __('Sign Up');
        $data['social'] = Social::get();
        $data['extra_page'] = ExtraPage::get();
        $data['gateways'] = PaymentGateway::where('status', 1)->get();
        return view('user.auth.register',$data);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $ex = Extension::where('act','google-recaptcha')->first();
        if (($ex->status == 1) && ($request->input('g-recaptcha-response') == '')){
            return back()->with('alert', 'Invalid captcha');
        }
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        $adminNotification = new Notification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('user.view',$user->id);
        $adminNotification->save();

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

}
