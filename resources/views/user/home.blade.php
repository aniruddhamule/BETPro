@extends('user.layouts.master')
@section('content')

<div class="currency-area">
    <div class="row">
        <div class="col-lg-12">
            <div class="input-group referral-input-box mb-3">
                <input type="text" class="form-control" id="myInputref" readonly  value="{{url('/')}}/register/{{auth()->user()->referral_token}}">
                <button class="input-group-text btn btn-base myrefButtonFunction" type="button" onclick="myrefButtonFunction()">{{__('Copy Referral Link')}}</button>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="media single-currency-inner image-hover-rotate">
                <div class="media-left align-self-center">
                    <img class="rotate-img" src="{{asset('public/frontend/img/corrency/1.png')}}" alt="img">
                </div>
                <div class="media-body">
                    <p>{{__('TOTAL BALANCE')}}</p>
                    <h3>{{number_format(auth()->user()->balance,2)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="media single-currency-inner image-hover-rotate">
                <div class="media-left align-self-center">
                    <img class="rotate-img" src="{{asset('public/frontend/img/corrency/1.png')}}" alt="img">
                </div>
                <div class="media-body">
                    <p>{{__('TOTAL PREDICT')}}</p>
                    <h3>{{@number_format($totalPrediction,2)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="media single-currency-inner image-hover-rotate">
                <div class="media-left align-self-center">
                    <img class="rotate-img" src="{{asset('public/frontend/img/corrency/1.png')}}" alt="img">
                </div>
                <div class="media-body">
                    <p>{{__('TOTAL INVEST')}}</p>
                    <h3>{{@number_format($invest_turnament,2)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="media single-currency-inner image-hover-rotate">
                <div class="media-left align-self-center">
                    <img class="rotate-img" src="{{asset('public/frontend/img/corrency/1.png')}}" alt="img">
                </div>
                <div class="media-body">
                    <p>{{__('TOTAL WIN')}}</p>
                    <h3>{{@number_format($win_turnament,2)}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chart-area bg-black-2 border-radius-10 mt-4">
    <div class="chart-header p-4 bg-black-3 pb-3">
        <div class="row">
            <div class="col-sm-8 align-self-center">
                <h5 class="mb-0">{{__('Wining Chart '. date('Y'))}}</h5>
            </div>
        </div>
    </div>
    <div class="chart p-md-4 p-3">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
</div>

@endsection
@section('script')
    <script src="{{ asset('public/frontend/js/chart.js?id=').rand() }}"></script>
    <script src="{{ asset('public/frontend/js/home_page.js?id=').rand() }}" data-won="{{json_encode($chart_value_monthwise)}}"></script>
@endsection