@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(array('route' => 'general.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'forms-sample')) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>{{__('Logo Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                            {!! Form::file('logo', array('id' => 'file-input', 'class' => 'form-control')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview" class="img-fluid" src="{{asset('public/images/logo/logo.png')}}" alt="your image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>{{__('Favicon Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                            {!! Form::file('favicon', array('id' => 'file-input2', 'class' => 'form-control')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain2'>
                                        <img id="image-preview2" class="img-fluid" src="{{asset('public/images/logo/favicon.png')}}" alt="your image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

