@extends('admin.layouts.master')
@section('content')
    <div class="card">
        {!! Form::model($general, array('route' => 'general.store',$general->id, 'class' => 'forms-sample', 'method' => 'POST')) !!}
        <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                    <h5 class="card-title">{{__('Odds API Docs V4')}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{__('Sports betting API covering odds from bookmakers around the world.')}}</h6>
                    <p class="card-text">{{__('The Live Odds API delivers near real-time odds for live (in-play) and upcoming sports events from several bookmakers. Sports odds data is no older than a few seconds to a few minutes, updating more frequently as games go live. Outrights (futures) odds data is less dynamic and is updated every hour pre-match, and more frequently when games go live.')}}</p>
                    <p class="card-text"> <span class="badge bg-danger">{{__('This API does not return RESULT ODDS')}}</span> {{__('Lean more & checkout ')}} <a href="https://the-odds-api.com/" target="_blank">odds-api</a></p>
                    <p class="card-text">{{__('Follow the odds API in 3 steps and upgrade bellow API HOST & API KEY.')}}</p>
                </div>

            </div>
            <div class="row mt-2">
                <div class="col-lg-6 ">
                    <div class="form-group">
                        <label><strong>{{__('Host')}}</strong></label>
                        {!! Form::text('api_url', null, array('placeholder' => 'url','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('Api Key')}}</strong></label>
                        {!! Form::text('api_key', null, array('placeholder' => 'key','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Market Key')}}</strong></label>
                        <select class="form-select" name="market_key">
                            <option value="betfair" {{$general->market_key == 'betfair'?'selected':''}}>{{__('Betfair')}}</option>
                            <option value="unibet" {{$general->market_key == 'unibet'?'selected':''}}>{{__('Unibet')}}</option>
                            <option value="betway" {{$general->market_key == 'betway'?'selected':''}}>{{__('Betway')}}</option>
                            <option value="1xbet" {{$general->market_key == '1xbet'?'selected':''}}>{{__('1xbet')}}</option>
                            <option value="betonline" {{$general->market_key == 'betonline'?'selected':''}}>{{__('Betonline')}}</option>
                            <option value="bet365" {{$general->market_key == 'bet365'?'selected':''}}>{{__('Bet365')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Minimum Batting Amount')}}</strong></label>
                        {!! Form::text('min_amt', null, array('placeholder' => 'Amount', 'class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Maximum Batting Amount')}}</strong></label>
                        {!! Form::text('max_amt', null, array('placeholder' => 'Amount', 'class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection