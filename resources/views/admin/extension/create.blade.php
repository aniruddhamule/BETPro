@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(array('route' => 'extension.store', 'class' => 'forms-sample', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
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
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label><strong>{{__('Name')}}</strong></label>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('App Key')}}</strong></label>
                                    {!! Form::text('script', null, array('placeholder' => 'App Key','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">{{__('Submit')}}</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection