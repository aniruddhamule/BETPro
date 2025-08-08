@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-end"><a href="{{route('admin.manual.gateway')}}" class="btn btn-sm s7__btn-dark @if(Request::routeIs('admin.manual.gateway')) active @endif">
                <i class="las la-arrow-left"></i> {{__('Go Back')}}
                </a>
            </h4>
            {!! Form::open(array('route' => 'gateway.store', 'class' => 'forms-sample', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                                    {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control', 'required')) !!}
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div id='img_contain'>
                                                <img id="image-preview" class="img-fluid" src="{{asset('public/images/no-image.png')}}" alt="your image"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{__('Name of Gateway')}}</strong></label>
                                    <input type="text" value="" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{__('Rate')}}</strong></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">1 USD = </span>
                                        <input name="rate" type="text" class="form-control">
                                        <span class="input-group-text"> {{ $general->currency }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3 max-width-18rem">
                                    <div class="card-header bg-primary text-white"><strong>{{__('Deposit Limit')}}</strong></div>
                                    <div class="card-body">
                                        <label><strong>{{__('Minimum Amount')}}</strong></label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="minimum_deposit_amount" class="form-control">
                                            <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                        </div>
                                        <label><strong>{{__('Maximum Amount')}}</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="maximum_deposit_amount" class="form-control">
                                            <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white"><strong>{{__('Deposit Charge')}}</strong></div>
                                    <div class="card-body">
                                        <label><strong>{{__('Fixed Charge')}}</strong></label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="fixed_charge" class="form-control" placeholder="">
                                            <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                        </div>
                                        <label><strong>{{__('Charge in Percentage')}}</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="percentage_charge" class="form-control">
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{__('Status')}}</strong></label>
                                    <select class="form-select" name="status">
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Inactive')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                

                <div class="form-group">
                    <label><strong>{{__('Payment Details')}}</strong></label>
                    <textarea name="gateway_key_four" rows="3" cols="80" class="form-control"></textarea>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn s7__btn-primary me-2">{{__('Submit')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection