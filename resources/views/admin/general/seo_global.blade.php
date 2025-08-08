@extends('admin.layouts.master')
@section('content')
    <div class="card">
        {!! Form::model($general, array('route' => 'general.store',$general->id, 'class' => 'forms-sample', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{__('Seo Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                        {!! Form::file('seo_image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div id='img_contain'>
                                    <img id="image-preview" class="img-fluid" src="{{asset('public/images/seo/seo_image.png')}}" alt="your image"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('Meta Title')}}</strong></label>
                        {!! Form::text('meta_title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('Meta Tag')}}</strong></label>
                        {!! Form::text('meta_tag', null, array('placeholder' => 'Tag','class' => 'form-control')) !!}
                        <small class="text-primary">{{__('Use comma separated. For example: BBC,CCN,Invest,...')}}</small>
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('Meta Description')}}</strong></label>
                        {!! Form::textarea('meta_description', null, array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-4 me-2">{{__('Submit')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

