@extends('user.layouts.master')
@section('content')
<div class="payment-area bg-navy-2 pd-bottom-220">
    <div class="container-sub">
        <div class="row">
            @foreach ($gateways as $data)
            <div class="col-lg-3 align-self-center">
                <div class="single-payment-wrap">
                    <div class="thumb">
                        <img src="{{$data->image_url}}" alt="{{$data->name}}">
                    </div>
                    <div class="details">
                        <h4>{{__($data->name)}}</h4>
                        <button class="btn btn-base" data-bs-target="#withdrawModal{{$data->id}}" data-bs-toggle="modal">{{__('Withdraw Now')}}</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="withdrawModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-dark">{{__('Withdraw via')}} <strong>{{__($data->name)}}</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{route('withdraw.preview.user')}}">
                            @csrf
                            <div class="modal-body">
                                <p class="text-danger">{{__('Charge for withdraw Amount')}}: {{$data->chargefx}} {{$general->currency}}</p>
                                <p class="text-dark">{{__('Percentage Charge')}}: {{$data->chargepc}} %</p>
                                <p class="text-danger">{{__('Processing Days (At last)')}} : {{$data->processing_day}} {{__('Days')}}</p>
                                <p class="text-success"> {{__('Minimum')}} {{$data->min_amo}} {{$general->currency}} & {{__('Maximum')}} {{$data->max_amo}} {{$general->currency}}</p>
                                <hr/>
                                <input type="hidden" name="gateway" value="{{$data->id}}">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="amount" placeholder="{{__('Amount You Want To Withdraw')}}" type="text" class="form-control" autocomplete="off" min="0" required>
                                        <span class="input-group-text">{{$general->currency}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">{{__('Preview')}}</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('Close')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
