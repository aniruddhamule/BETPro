@extends('admin.layouts.master')
@section('content')
    <div class="card">
        {!! Form::model($general, array('route' => 'general.store',$general->id, 'class' => 'forms-sample', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                        {!! Form::file('about_image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div id='img_contain'>
                                    <img id="image-preview" class="img-fluid" src="{{asset('public/images/about/about_image.png')}}" alt="your image"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label><strong>{{__('Title')}}</strong></label>
                        {!! Form::text('about_title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('Description')}}</strong></label>
                        {!! Form::textarea('about_description', null, array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection