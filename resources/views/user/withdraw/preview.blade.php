@extends('user.layouts.master')
@section('content')
<section class="match_details_section pd-bottom-120 bg-navy-2">
    <div class="container-sub">
        <div class="rows d-flex justify-content-center bg-black-2 p-4 rounded-3">
            <div class="col-md-6 mt-5 mb-5">
                <div class="text-center">
                    <img src="{{asset('public/images/withdraw/'.$method->image)}}" class="rounded" alt="{{__('Withdraw Image')}}">
                </div>
            </div>
            <div class="col-md-6 mt-5 mb-5">
                <form method="POST" action="{{route('confirm.withdraw.store')}}">
                @csrf
                
                @php
                    $charge = ((floatval($amount) * floatval($method->chargepc))/100) + floatval($amount) + floatval($method->chargefx);
                @endphp
                <input type="hidden" name="amount" value="{{$amount}}">
                <input type="hidden" name="method_id" value="{{$method->id}}" >

                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active" aria-current="true"> {{__('Request for Withdraw Amount')}}: <strong>{{$amount}}</strong> {{$general->currency}}</li>
                            <li class="list-group-item">{{__('Charge')}} : <strong>{{((floatval($amount) * floatval($method->chargepc))/100)+ floatval($method->chargefx)}}</strong> {{$general->currency}} | ({{$method->chargepc}} % + {{$method->chargefx}} {{$general->currency}}) </li>
                            <li class="list-group-item">{{__('Total Amount Deduct')}}: <strong>{{$charge}}</strong> {{$general->currency}}</li>
                            <li class="list-group-item">{{__('In')}} {{$method->currency}}: <strong>{{round($amount*$method->rate, 4)}}</strong> {{$method->currency}}</li>
                            <li class="list-group-item">{{__('Payment Gateway')}}: <strong>{{$method->name}}</strong> </li>
                        </ul>
                        <div class="model-body table-responsive text-center">
                            <strong class="col-md-12">{{__('Information Of Withdraw Money')}}</strong>
                            <textarea class="form-control" name="detail" rows="5" placeholder="{{__('Provide all information')}}"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5 text-center">
                        <button class="btn btn-base withdrawBtn" type="submit" id="btn-confirm">{{__('Confirm Withdraw')}} <i class="fas fa-arrow-circle-right ms-2"></i></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection