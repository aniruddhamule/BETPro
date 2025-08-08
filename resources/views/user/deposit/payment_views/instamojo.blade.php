@extends('user.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
   <div class="container">
       <div class="row">
           <div class="col-12">
               <div class="section-title style-white text-center">
                   <h2 class="title">{{__('Instamojo Payment')}}</h2>
               </div>
           </div>
       </div>
       <div class="contact-inner">
           <div class="row justify-content-center">
               <div class="col-lg-6">
                  <form id="payment-card-info" method="post" action="{{ route('instamojo.pay') }}">
                     @csrf
                     <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Your Full Name')}}</span>
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <input type="text" name="name" placeholder="{{__('Enter Name')}}" required>
                     </div>
                     <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Email Address')}}</span>
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        <input type="text" name="email" placeholder="{{__('Enter Email')}}" required>
                     </div>
                     <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Phone Number')}}</span>
                        <span class="icon"><i class="fa fa-phone-alt"></i></span>
                        <input type="text" name="mobile_number" placeholder="{{__('Enter Mobile Number')}}" required>
                     </div>
                     <div class="text-center mb-3">
                        <button class="btn btn-base" type="submit">{{__('Submit')}}</button>
                     </div>
                  </form>
               </div>
           </div>
       </div>
   </div>
</div>

@endsection
