@extends('user.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title style-white text-center">
                    <h2 class="title">{{__('Sceurionpay Payment')}}</h2>
                </div>
            </div>
        </div>
        <div class="contact-inner">
            <div class="row justify-content-center">
                <div class="col-12">
					<form role="form" action="{{ route('sceurionpay.ipn')}}" method="post">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Name on Card')}}</span>
									<span class="icon"><i class="fa fa-credit-card"></i></span>
									<input class="name form-control" id="the-card-name-id" name="card_name" placeholder="{{__('Enter the name on your card')}}"
									autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Card Number')}}</span>
									<span class="icon"><i class="fa fa-credit-card"></i></span>
									<input class="card-number form-control" name="card_number" placeholder="{{__('Enter your card number')}}"
                            		autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('CVV')}}</span>
									<span class="icon"><i class="fa fa-address-card"></i></span>
									<input autocomplete="off" class="card-cvc" placeholder="{{__('ex. 311')}}" type="text">
								</div>
							</div>
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Expiration Month')}}</span>
									<span class="icon"><i class="fa fa-calendar"></i></span>
									<input class="card-expiry-month" name="expiry_month" placeholder='MM' type='text'>
								</div>
							</div>
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Expiration Year')}}</span>
									<span class="icon"><i class="fa fa-calendar"></i></span>
									<input class="card-expiry-year" name="expiry_year" placeholder="{{__('YYYY')}}" type="text">
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							<button class="btn btn-base" type="submit">{{__('Pay Now')}}</button>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection