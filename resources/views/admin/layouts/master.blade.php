<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{@$general->web_name}} | {{$page_title}}</title>
        <link rel="icon" type="image/png" href="{{asset('public/images/logo/favicon.png')}}" sizes="16x16" />
        @include('admin.layouts.partials.style')
        @yield('style')
    </head>
    <body>

        <div class="preloader">
            <div class="preloader-icon-img">
                <img src="{{asset('public/backend/images/spinner.svg')}}" alt="preloader spinner">
            </div>
        </div>
        
        @include('admin.layouts.partials.nav')

        <div class="body-area">
            @include('admin.layouts.sidebar')
            <main class="s7__main">
                <div class="s7__page-nav">
                    <div class="left">
                      <h6 class="title text-uppercase">{{$page_title}}</h6>
                    </div>
                    <div class="right">
                      <ul>
                        <li><a href="{{route('admin.home')}}">{{__('Dashboard')}}</a></li>
                        <li>{{$page_title}}</li>
                      </ul>
                    </div>
                  </div>
                @yield('content')
            </main>
            
        </div>

        @include('admin.layouts.partials.script')
        @include('admin.layouts.partials.messages')
        @yield('script')
    </body>
</html>