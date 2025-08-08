@extends('user.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title style-white text-center">
                    <h2 class="title">{{__('Stripe Payment')}}</h2>
                </div>
            </div>
        </div>
        <div class="contact-inner">
            <div class="row justify-content-center">
                <div class="col-12">
					<form role="form" action="{{ route('ipn.stripe')}}" method="post" class="strip-validation"
						data-cc-on-file="false"
						data-stripe-publishable-key="{{ $gateway->gateway_key_two }}"
						id="payment-form">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Name on Card')}}</span>
									<span class="icon"><i class="fa fa-credit-card"></i></span>
									<input type="text" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Card Number')}}</span>
									<span class="icon"><i class="fa fa-credit-card"></i></span>
									<input autocomplete="off" class="card-number" type="text">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('CVV')}}</span>
									<span class="icon"><i class="fa fa-address-card"></i></span>
									<input autocomplete="off" class="card-cvc" placeholder="{{__('ex. 123')}}" type="text">
								</div>
							</div>
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Expiration Month')}}</span>
									<span class="icon"><i class="fa fa-calendar"></i></span>
									<input class="card-expiry-month" placeholder="MM" type="text">
								</div>
							</div>
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Expiration Year')}}</span>
									<span class="icon"><i class="fa fa-calendar"></i></span>
									<input class="card-expiry-year" placeholder="{{__('YYYY')}}" type="text">
								</div>
							</div>
						</div>
						<div class="single-form-check form-check">
							<div class='col-md-12 error form-group hide'>
								<div class='alert-danger alert'>{{__('Please correct the errors and try again.')}}</div>
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

@stop
@section('script')
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@endsection
