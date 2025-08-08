<div class="col-xl-2 col-lg-3">
    <div class="main-sitebar">
        <div class="dropdown-widget">
            <ul>
                <li class="list-heading"><a href="javascript:void(0)"><img src="{{asset('public/frontend/img/flag/0.png')}}" alt="img"> {{__('Top Competitions')}}</a></li>
                @forelse ($recentWinners as $data)
                    <li><a href="javascript:void(0)">{{$data->user->name}} <span>{{getAmount($data->return_amount)}} {{__($general->currency)}}</span></a></li>
                @empty
                    <li> <p class="text-danger text-center"> {{__('No winner found')}} </p></li>
                @endforelse
            </ul>
        </div>
        <div class="dropdown-widget">
            <img src="{{asset('public/frontend/img/add2.png')}}" alt="img">
        </div>
    </div>
</div>