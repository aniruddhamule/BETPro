@extends('user.layouts.master')
@section('content')

@php
    $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
@endphp
<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title style-white text-center">
                    <h2 class="title">{{__('Authorize.Net Payment')}}</h2>
                </div>
            </div>
        </div>
        <div class="contact-inner">
            <div class="row justify-content-center">
                <div class="col-12">
					<form id="payment-card-info" method="post" action="{{ route('authorize.dopay.online') }}">
                        @csrf
						<div class="row">
							<div class="col-md-6">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Name on Card')}}</span>
									<span class="icon"><i class="fa fa-credit-card"></i></span>
									<input type="text" id="owner" name="owner" value="{{'Simon'}}" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Card Number')}}</span>
									<span class="icon"><i class="fa fa-credit-card"></i></span>
									<input type="text" id="cardNumber" name="cardNumber" value="{{'4111 1111 1111 1111'}}" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('CVV')}}</span>
									<span class="icon"><i class="fa fa-address-card"></i></span>
									<input type="text" id="cvv" name="cvv" value="{{'123'}}" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="single-input-inner style-border">
									<span class="input-group-text">{{__('Amount')}}</span>
									<span class="icon"><i class="fa fa-dollar-sign"></i></span>
                                    <input type="number" id="amount" readonly name="amount" min="1" value="{{ $usd_amo }}" required>
								</div>
							</div>
                            <div class="col-md-4">
                                <div class="single-input-inner style-border">
                                    <span class="input-group-text">{{__('Expiration Date')}}</span>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-select author_month" id="expiration-month" name="expiration-month">
                                                @foreach($months as $k=>$v)
                                                    <option value="{{ $k }}" {{ old('expiration-month') == $k ? 'selected' : '' }}>{{ $v }}</option>                                                        
                                                @endforeach
                                            </select>  
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-select author_year" id="expiration-year" name="expiration-year">
                                                @for($i = date('Y'); $i <= (date('Y') + 15); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single-input-inner style-border">
                                    <img class="author_img" src="{{ asset('public/images/gateway/visa.png') }}" id="visa">
                                    <img class="author_img" src="{{ asset('public/images/gateway/mastercard.jpg') }}" id="mastercard">
                                    <img class="author_img" src="{{ asset('public/images/gateway/american-express.png') }}" id="amex">
                                </div>
                            </div>
                        </div>

						<div class="text-center mb-3">
							<button class="btn btn-base" type="submit">{{__('Confirm Payment')}}</button>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection