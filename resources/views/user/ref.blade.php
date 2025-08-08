@extends('user.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('public/frontend/css/tree.css')}}">
@stop
@section('content')

<div class="leaderboard-area pd-bottom-90 bg-navy-2">
    <div class="container-sub">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="tab-pane deposit-tab fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="part-text pranto-ul">
                        <ul class="width-100">
                            <li class="container"><h5> <span class="badge bg-primary"><strong>{{Auth::user()->name}} {{__('(me)')}}</strong> </span> </h5>
                                <ul>
                                    {!! showBelowUser(Auth::id()) !!}
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection