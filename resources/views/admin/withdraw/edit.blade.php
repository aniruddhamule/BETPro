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
            {!! Form::model($withdraw, ['method' => 'PATCH','route' => ['withdraw.update', $withdraw->id], 'class' => 'forms-sample', 'enctype' => 'multipart/form-data']) !!}
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control" value="{{$withdraw->id}}" type="hidden" name="id">
                            <div class="form-group">
                                <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                                {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div id='img_contain'>
                                            <img id="image-preview" class="img-fluid" src="{{asset('public/images/withdraw/'.$withdraw->image)}}" alt="your image"/>
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
                                        {!! Form::text('name', null, array('id' => 'name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>{{__('Currency')}} <span class="text-danger">*</span></strong></label>
                                        {!! Form::text('currency', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>{{__('Rate')}} <span class="text-danger">*</span></strong></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">1 USD = </span>
                                            {!! Form::text('rate', null, array('class' => 'form-control')) !!}
                                            <span class="input-group-text"> {{ $general->currency }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>{{__('Processing Time')}} <span class="text-danger">*</span></strong></label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('processing_day', null, array('class' => 'form-control')) !!}
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
                                                {!! Form::number('min_amo', null, array('class' => 'form-control')) !!}
                                                <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                            </div>
                                            <label><strong>{{__('Maximum Amount')}} <span class="text-danger">*</span></strong></label>
                                            <div class="input-group">
                                                {!! Form::number('max_amo', null, array('class' => 'form-control')) !!}
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
                                                {!! Form::text('chargefx', null, array('class' => 'form-control')) !!}
                                                <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                            </div>
                                            <label><strong>{{__('Charge in Percentage')}} <span class="text-danger">*</span></strong></label>
                                            <div class="input-group">
                                                {!! Form::text('chargepc', null, array('class' => 'form-control')) !!}
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{__('Status')}} <span class="text-danger">*</span></strong></label>
                                        <select class="form-select" name="status">
                                            <option value="1" {{$withdraw->status==1?'selected':''}}>{{__('Active')}}</option>
                                            <option value="0" {{$withdraw->status==0?'selected':''}}>{{__('Inactive')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn s7__btn-primary mt-2 me-2">{{__('Update')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection