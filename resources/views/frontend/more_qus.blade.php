@extends('frontend.layouts.master')
@section('content')
<div class="main-body-area">
    <div class="row">
        @include('frontend.layouts.partials.leftbar')
        <div class="col-xl-8 col-lg-6">
            <div class="more-qus-area border-radius-5 bg-black-2 mb-4">
                <h4 class="text-center bg-black-4 p-xl-3 p-2 px-3">{{$page_title}}</h4>
                @forelse ($questions as $data)
                <div class="m-3 m-xl-4 p-3 p-xl-4 bg-black border-radius-5">
                    <h6 class="">{{__($data->question)}}</h6> 
                    <div class="row">
                        @foreach ($data->options as $item)
                        <div class="col-md-6">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#sportModal"
                            data-team-name="{{$item->option_name}}"
                            data-confrontation="{{$item->match->name}}"
                            data-id="{{$item->id}}"
                            data-minamo="{{$item->min_amo}}"
                            data-macthid="{{$item->match->id}}"
                            data-ratioone="{{$item->ratio1}}"
                            data-ratiotwo="{{$item->ratio2}}"
                            data-betlimit="{{$item->bet_limit}}"
                            data-questionid="{{$item->question->id}}"
                            data-wager-count="{{$item->ratio1}} X {{$item->ratio2}}" class="bet_button qus-predict-item bg-black-2 p-2 border-radius-5 px-3">
                                {{__($item->option_name)}}
                                <span class="float-end">{{$item->ratio1}} X {{$item->ratio2}}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @include('frontend.layouts.partials.rightbar')
        
    </div>
</div>

@if(Auth::user())
<div class="modal fade bet--model" id="sportModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-cust">
            <div class="modal-header modal-title-cust">
                <h5 class="modal-title" id="ModalLabel">{{__('Prediction Now')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(array('route' => 'user.prediction', 'method'=>'POST')) !!}
            <div class="modal-body text-center">
                <div class="form-group">
                    <strong>{{__('Amount')}}</strong>
                    <input name="invest_amount" class="ctrl_counter-input form-input invest_amount_min subro_bet get_amount_for_ratio" maxlength="10" type="text" value="" min="" max="">
                    <input type="hidden" name="betoption_id" id="betoption_id">
                    <input type="hidden" name="match_id" id="match_id">
                    <input type="hidden" name="betquestion_id" id="questionid">
                    <input class="ratio1" type="hidden" id="ratioOne">
                    <input class="ratio2" type="hidden" id="ratioTwo">
                    <input class="form-control input-lg subro_ratio" name="return_amount" type="hidden">
                </div>
                <hr>
                <div class="form-group">
                    <span class="font-weight-bold text--white">{{__('MINIMUM PREDICT AMOUNT')}} <span class="minamo text--white"></span> {{__($general->currency)}}</span>
                </div>
                <small class="text--white">({{__('IF YOU WIN')}})</small>
                <p class="modal-sport-win">
                    <span class="font-weight-bold text--white">{{__('RETURN AMOUNT')}}</span>
                    <span class="font-weight-bold text--white"><span class="wining-rate"></span> {{$general->currency}}</span>
                </p>
                <p class="text-danger">0% {{__('Charge Apply From This Amount')}}
                    ({{__('IF YOU WIN')}}) </p>
                <p class="text-success">{{__('Maximum')}} <span class="betlimit"></span> {{$general->currency}} {{__('Predict in this Option')}} </p>
            </div>
            <div class="modal-footer modal-footer-cust justify-content-center">
              <button type="submit" class="btn1 btn--success text--white">{{__('Predict Now')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@else
<div class="modal fade bet--model" id="sportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content modal-content-cust">
        <div class="modal-header modal-title-cust">
          <h5 class="modal-title" id="exampleModalLabel">{{__('Login Required')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="bet-predict-content">
            <h6 class="subtitle">{{__('Placing Bet Requires Login')}}</h6>
            <div class="bet-limit">
                <span>{{__('If you are already with us then please')}} </span> <span><a href="{{ route('login') }}" class="text--base">{{__('login')}}</a></span> <span>{{__('otherwisw')}}</span> <span><a href="{{ route('register') }}" class="text--base">{{__('register')}}</a></span>
            </div>
          </div>
        </div>
        <div class="modal-footer modal-footer-cust">
          <button type="button" class="btn1 btn--danger text--white" data-bs-dismiss="modal">{{__('Close')}}</button>
          <a href="{{ route('login') }}" type="button" class="btn1 btn--success text--white">{{__('Login')}}</a>
        </div>
      </div>
    </div>
</div>
@endif

<div class="client-area">
    <div class="container">
        <h3 class="main-title mb-5 text-center">{{__('Our Payment Methods')}}</h3>
        <div class="client-slider owl-carousel">
            @foreach ($gateways as $data)
                <div class="thumb text-center">
                    <img src="{{asset('public/images/gateway/'.$data->image)}}" alt="img">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
