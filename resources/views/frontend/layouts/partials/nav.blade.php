<div class="body-overlay" id="body-overlay"></div>

@guest
<div class="sidebar-menu" id="sidebar-menu">
    <button class="sidebar-menu-close"><i class="fa fa-times"></i></button>
    <div class="sidebar-inner">
        <a class="mb-5 d-block" href="{{url('/')}}"><img src="{{asset('public/images/logo/logo.png')}}" alt="img"></a>
        <ul class="single-sitebar-menu m-0 p-0">
            <li><a href="{{ url('/') }}">{{__('Home')}}</a></li>
            <li><a href="{{ route('frontend.about.index') }}">{{__('About Us')}}</a></li>
            <li><a href="{{ route('frontend.news.index') }}">{{__('News')}}</a></li>
            @if ($section_btn->contact_switch == 1)
            <li><a href="{{ route('frontend.contact.index') }}">{{__('Contact Us')}}</a></li>
            @endif
        </ul>
    </div>
</div>
@endguest

@guest
<div class="sidebar-menu" id="sidebar-menu-mobile">
    <button class="sidebar-menu-close"><i class="fa fa-times"></i></button>
    <div class="sidebar-inner">
        <div class="main-sitebar">
            <div class="dropdown-widget">
                <ul>
                    <li class="list-heading"><a href="javascript:void(0)"><img src="{{asset('public/frontend/img/flag/0.png')}}" alt="img"> {{__('Categories')}}</a></li>
                    @foreach ($category as $key => $data)
                    <li>
                        <a data-bs-toggle="collapse"
                        href="#collapse{{$key+1}}"
                        role="button"
                        aria-expanded="true"
                        aria-controls="collapseExample">
                        <i class="fa fa-{{$data->icon}}" aria-hidden="true"></i> {{__($data->name)}} ({{$data->event()->whereStatus(1)->count()}})
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <div class="collapse" id="collapse{{$key+1}}">
                            <ul>
                                @foreach($data->event()->where('status',1)->get() as $event)
                                 <li>
                                    <a href="{{route('ui.tournament',[$event->cat->slug,$event->slug])}}">
                                    {{$event->name}}</a>
                                 </li>
                                 @endforeach
                                
                            </ul>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown-widget">
                <ul>
                    <li class="list-heading"><a href="javascript:void(0)"><img src="{{asset('public/frontend/img/flag/0.png')}}" alt="img"> {{__('Tournaments')}}</a></li>
                    @foreach ($tournaments as $data)
                        <li><a href="{{route('ui.tournament',[$data->cat->slug,$data->slug])}}"><i class="{{$data->cat->icon}}"></i> {{__($data->name)}}</a></li>
                    @endforeach
                </ul>
            </div>              
        </div>
    </div>
</div>
@endguest

<div class="navbar-top bg-black-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="topbar-select-inner mb-2 mb-md-0">
                    <select class="d-inline-block" id="langSel">
                        <option value="en">{{__('English')}}</option>
                        @foreach($lang as $data)
                        <option value="{{$data->code}}" @if(Session::get('lang') == $data->code) selected  @endif>{{$data->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4 align-self-center">
                <ul class="topbar-right text-md-end m-0 p-0 ">
                    <li class="social-area">
                        @guest
                            <a href="{{ route('login') }}">{{__('Login')}}</a>
                            <a href="{{ route('register') }}">{{__('Register')}}</a>
                        @else
                            <a href="{{ route('home') }}">{{__('Dashboard')}}</a>
                            @foreach ($social as $data)
                            <a class="{{$data->icon}}" href="{{$data->link}}">
                                <i class="fab fa-{{$data->icon}}"></i>
                            </a>
                            @endforeach
                        @endguest
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="navbar-bottom">
    <div class="container">
        <div class="row">
            <div class="col-6 align-self-center">
                <a href="{{url('/')}}"><img src="{{asset('public/images/logo/logo.png')}}" alt="img"></a>
            </div>
           
            <div class="col-6 text-end text-right">
                <div class="right-area-inner dashboard-user-menu">
                    @auth
                        <a href="javascript:void(0)"><img src="{{asset('public/frontend/img/author.png')}}" alt="img"></a>
                        <ul class="d-lg-none">
                            <li><a href="{{ route('home') }}">{{__('Dashboard')}} </a></li>
                            <li><a href="{{route('deposit.index')}}">{{__('Deposit')}}</a></li>
                            <li><a href="{{route('user.deposit.log')}}">{{__('Deposit Log')}}</a></li>
                            <li><a href="{{route('user.withdraw.method')}}">{{__('Withdraw')}}</a></li>
                            <li><a href="{{route('user.withdraw.log')}}">{{__('Withdraw Log')}}</a></li>
                            <li><a href="{{route('my.prediction')}}">{{__('Bets Log')}}</a></li>
                            <li><a href="{{route('user.transaction.log')}}">{{__('Transaction Log')}}</a></li>
                            <li><a href="{{route('profile.index')}}">{{__('Profile')}}</a></li>
                            <li><a href="{{route('user.ref.index')}}">{{__('Referral')}}</a></li>
                            <li><a href="{{route('password.index')}}">{{__('Change Password')}}</a></li>
                            <li><a href="{{route('two.factor.index')}}">{{__('2FA Security')}}</a></li>
                            <li><a href="{{route('user.support.index')}}">{{__('Support Ticket')}}</a></li>
                            <li><a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('Logout')}}</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    @endauth
                    @guest
                        <a class="menubar" id="navigation-button" href="javascript:void(0)"><img src="{{asset('public/frontend/img/icon/1.svg')}}" alt="img"></a>
                    @endguest
                    @guest
                        <a class="menubar-mobile d-lg-none" id="navigation-button-mobile" href="javascript:void(0)"><i class="fa fa-braille"></i></a>
                    @endguest
                </div>
            </div>
            
        </div>
    </div>
</div>

@guest
    <div class="bg-black-3 pt-4 pb-3">
        <div class="container">
            <div class="header-scroll-inner-wrap">
                <div class="header-scroll-inner">
                    @foreach ($category as $data)
                    <a href="{{route('ui.category', $data->slug)}}">
                        @if (!is_null($data->icon))
                            <i class="fas fa-{{$data->icon}}" aria-hidden="true"></i>
                        @endif
                        {{__($data->name)}}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endguest