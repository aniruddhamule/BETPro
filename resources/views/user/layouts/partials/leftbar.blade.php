<div class="col-xl-2 col-lg-3 d-lg-block d-none">
    <div class="main-sitebar">
        <div class="dropdown-widget">
            <h5><i class="fa fa-user"></i> {{auth()->user()->name}}</h5>
            <ul>
                <li><a href="{{ route('home') }}">{{__('Dashboard')}} </a></li>
                <li>
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample-2" aria-expanded="false" aria-controls="collapseExample-2">
                        {{__('Operations')}}
                        <i class="fa fa-angle-right"></i>
                    </button>
                    <div class="collapse" id="collapseExample-2">
                        <ul>
                            <li><a href="{{route('deposit.index')}}">{{__('Deposit')}}</a></li>
                            <li><a href="{{route('user.withdraw.method')}}">{{__('Withdraw')}}</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        {{__('My Log')}}
                        <i class="fa fa-angle-right"></i>
                    </button>
                    <div class="collapse" id="collapseExample">
                        <ul>
                            <li><a href="{{route('user.deposit.log')}}">{{__('Deposit Log')}}</a></li>
                            <li><a href="{{route('user.withdraw.log')}}">{{__('Withdraw Log')}}</a></li>
                            <li><a href="{{route('my.prediction')}}">{{__('Bets Log')}}</a></li>
                            <li><a href="{{route('user.transaction.log')}}">{{__('Transaction Log')}}</a></li>
                        </ul>
                    </div>
                </li>
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
        </div>
    </div>
</div>