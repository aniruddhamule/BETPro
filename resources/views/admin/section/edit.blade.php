@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::model($section, ['method' => 'PATCH','route' => ['section.update', $section->id], 'class' => 'forms-sample', 'enctype' => 'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                            {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview" class="img-fluid" src="{{asset('public/images/section/'.$section->image)}}" alt="your image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>{{__('Title')}}</strong></label>
                            {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Sub Title')}}</strong></label>
                            {!! Form::text('sub_title', null, array('placeholder' => 'Sub Title','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Description')}}</strong></label>
                            {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Update')}}</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

