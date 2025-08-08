@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-end"><a href="{{route('withdraw.index')}}" class="btn btn-sm s7__btn-dark @if(Request::routeIs('withdraw.index')) active @endif">
                <i class="las la-arrow-left"></i> {{__('All Withdrawals')}}
                </a>
            </h4>
        </div>
        <div class="card-body">
            {!! Form::open(array('route' => 'withdraw.store', 'class' => 'forms-sample', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>{{__('Method Name')}}</strong></label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>{{__('Currency')}} <span class="text-danger">*</span></strong></label>
                                        <input type="text" class="form-control" name="currency" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>{{__('Rate')}} <span class="text-danger">*</span></strong></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">1 USD = </span>
                                            <input name="rate" type="text" class="form-control" placeholder="0">
                                            <span class="input-group-text"> {{ $general->currency }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>{{__('Processing Time')}} <span class="text-danger">*</span></strong></label>
                                        <div class="input-group mb-3">
                                            <input name="processing_day" type="text" class="form-control" placeholder="{{__('Day')}}">
                                            <span class="input-group-text">{{__('Days')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card--custom mb-3">
                                        <div class="card-header bg-primary text-white"><strong>{{__('Range')}}</strong></div>
                                        <div class="card-body">
                                            <label><strong>{{__('Minimum Amount')}} <span class="text-danger">*</span></strong></label>
                                            <div class="input-group mb-3">
                                                <input type="number" name="min_amo" class="form-control" placeholder="0">
                                                <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                            </div>
                                            <label><strong>{{__('Maximum Amount')}} <span class="text-danger">*</span></strong></label>
                                            <div class="input-group">
                                                <input type="number" name="max_amo" class="form-control" placeholder="0">
                                                <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card--custom">
                                        <div class="card-header bg-primary text-white"><strong>{{__('Charge')}}</strong></div>
                                        <div class="card-body">
                                            <label><strong>{{__('Fixed Charge')}} <span class="text-danger">*</span></strong></label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="chargefx" class="form-control" placeholder="0">
                                                <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                            </div>
                                            <label><strong>{{__('Charge in Percentage')}} <span class="text-danger">*</span></strong></label>
                                            <div class="input-group">
                                                <input type="text" name="chargepc" class="form-control" placeholder="0">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn s7__btn-primary mt-2 me-2">{{__('Submit')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection