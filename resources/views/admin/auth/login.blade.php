<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{@$general->web_name}} | @yield('title', __('Admin Login'))</title>
        <link rel="icon" type="image/png" href="{{asset('public/images/logo/favicon.png')}}" sizes="16x16" />
        @include('admin.layouts.partials.style')
        @yield('style')
    </head>
    <body>

      <div class="auth-page">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-4">
              <div class="auth-card">
                <div class="text-center mb-5">
                  <a href="{{route('admin.home')}}" class="auth-logo"><img src="{{asset('public/images/logo/logo.png')}}" alt="logo"></a>
    
                  <h5 class="mt-3">{{__('Admin Login')}}</h5>
                </div>
                <form id="myForm" role="form" action="{{ route('admin.login') }}" method="post">
                  @csrf
                  <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{old('email')}}" autofocus>
                  </div>
                  <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                  </div>
                  @if ($general->g_captcha == 1)
                    <div class="form-group mb-3">
                        <div class="col-md-12">
                            <div class="g-recaptcha" data-sitekey="{{$general->captcha_key_one}}"></div>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                  @endif
                  <button type="submit" class="btn s7__bg-primary text-white w-100">Login</button>
  
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      @include('admin.layouts.partials.script')
      @include('admin.layouts.partials.messages')
      @yield('script')
    </body>
</html>