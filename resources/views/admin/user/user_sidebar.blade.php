<div class="col-xl-4 col-lg-6 col-md-6 grid-margin stretch-card">
    <div class="card mb-3">
        <div class="card-body">
            <div>
                <img height="285" width="285" src="{{asset('public/images/no-image.png')}}" alt="img">
            </div>
            <div class="mt-2">
                <h4>{{ucfirst($user->name)}}</h4>
            </div>
            <span class="text--small">{{__('Joined At')}} <strong>{{$user->created_at->format('d M,Y h:i A')}}</strong></span>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-20">{{__('User information')}}</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{__('Email')}}<span class="font-weight-bold">{{$user->email}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{__('Status')}}<span class="badge bg-{{($user->status == 1) ? 'success' :'danger'}} success">{{($user->status==1) ? __('Active') : __('Inactive')}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{__('Balance')}}<span class="font-weight-bold">{{getAmount($user->balance,2)}} {{$general->currency}}</span>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h5 class="mb-20">{{__('User action')}}</h5>
            <div class="list-group">
                <a href="{{route('user.view',[$user->id])}}" class="@if(Request::routeIs('user.view')) active @endif list-group-item list-group-item-action">{{__('Profile Setting')}} <i class="mdi mdi-face-profile float-right"></i></a>
                <a href="{{route('user.password',[$user->id])}}" class="@if(Request::routeIs('user.password')) active @endif list-group-item list-group-item-action">{{__('Password Setting')}} <i class="mdi mdi-key float-right"></i></a>
                <a href="{{route('user.balance',[$user->id])}}" class="@if(Request::routeIs('user.balance')) active @endif list-group-item list-group-item-action">{{__('Manage Balance')}} <i class="mdi mdi-wallet float-right"></i></a>
                <a href="{{route('user.email',[$user->id])}}" class="@if(Request::routeIs('user.email')) active @endif list-group-item list-group-item-action">{{__('Send Email')}} <i class="mdi mdi-mail float-right"></i></a>
                <a href="{{route('user.predictions',[$user->id])}}" class="@if(Request::routeIs('user.predictions')) active @endif  list-group-item list-group-item-action">{{__('Prediction Log')}} <i class="mdi mdi-stack-exchange float-right"></i></a>
                <a href="{{route('user.paymentLog',[$user->id])}}" class="@if(Request::routeIs('user.paymentLog')) active @endif list-group-item list-group-item-action">{{__('Payment Log')}} <i class="mdi mdi-stack-exchange float-right"></i></a>
                <a href="{{route('user.withdrawLog',[$user->id])}}" class="@if(Request::routeIs('user.withdrawLog')) active @endif list-group-item list-group-item-action">{{__('Withdraw Log')}} <i class="mdi mdi-stack-exchange float-right"></i></a>
                <a href="{{route('user.transactionLog',[$user->id])}}" class="@if(Request::routeIs('user.transactionLog')) active @endif  list-group-item list-group-item-action">{{__('Transaction')}} <i class="mdi mdi-stack-exchange float-right"></i></a>
            </div>
            
        </div>
    </div>
</div>