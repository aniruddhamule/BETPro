<div class="schedule-area mt-4">
    @forelse($matches as $key => $data)
    <div class="single-schedule-inner text-center">
        <div class="row no-gutters">
            <div class="col-xl-6 align-self-center">
                <div class="schedule-left">
                    <div class="row">
                        <div class="col-sm-4 empty-schedule-top">
                            @if(!is_null($data->team_1_image))
                            <img src="{{asset('public/images/match/'.$data->team_1_image)}}" alt="img">
                            @endif
                            <p class="mb-0 mt-3">{{$data->team_1}}</p>
                        </div>
                        <div class="col-sm-4">
                            <p>{{$data->event->name}}</p>
                            <h4 class="color-base">VS</h4>
                            @if (\Carbon\Carbon::parse($data->end_date) > \Carbon\Carbon::now())
                            <p class="time" id="counter{{$data->id}}"></p>
                            <script>
                                createCountDown('counter<?php echo $data->id ?>', {{ \Carbon\Carbon::parse($data->end_date)->diffInSeconds()}});
                            </script>
                            @endif
                        </div>
                        <div class="col-sm-4 empty-schedule-top">
                            @if(!is_null($data->team_2_image))
                            <img src="{{asset('public/images/match/'.$data->team_2_image)}}" alt="img">
                            @endif
                            <p class="mb-0 mt-3">{{$data->team_2}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if($data->questions->count())
            <div class="col-xl-6 align-self-center">
                <div class="schedule-right pl-xl-4 ps-xl-4 mt-xl-0 mt-4">
                    <h4>{{__($data->questions->first()->question)}}</h4>
                    <div class="row">
                        @foreach ($data->questions->first()->options()->limit(3)->get() as $item)
                            <div class="col-4">
                                <p>{{__($item->option_name)}}</p>
                                <a class="bet_button" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#sportModal"
                                data-team-name="{{$item->option_name}}"
                                data-confrontation="{{$item->match->name}}"
                                data-id="{{$item->id}}"
                                data-minamo="{{$item->min_amo}}"
                                data-macthid="{{$item->match->id}}"
                                data-ratioone="{{$item->ratio1}}"
                                data-ratiotwo="{{$item->ratio2}}"
                                data-betlimit="{{$item->bet_limit}}"
                                data-questionid="{{$item->question->id}}"
                                data-wager-count="{{$item->ratio1}} X {{$item->ratio2}}">{{$item->ratio1}}
                                    X {{$item->ratio2}}</a>
                            </div>
                        @endforeach
                    </div>
                    @if($data->questions->count() > 1)
                    <div class="text-center mb-2 px-2 mx-xl-3 mt-4">
                        <a class="more_qus color-base" href="{{route('frontend.moreQus',$data->id)}}">{{__('More Questions')}}</a>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="empty-div">
                <span><small>@lang('No question yet')</small></span>
            </div>
            @endif
        </div>
    </div>
    @empty
        <p class="text-danger text-center"> {{__('No Open Playing found')}} </p>
    @endforelse
    
    <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
        {{$matches->links('pagination::bootstrap-4')}} 
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