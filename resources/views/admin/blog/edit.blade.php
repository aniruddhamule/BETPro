@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-end"><a href="{{route('news.index')}}" class="btn btn-sm btn-primary @if(Request::routeIs('news.index')) active @endif">
                <i class="las la-arrow-left"></i> {{__('All News')}}
                </a>
            </h4>
        </div>
        <div class="card-body">
            {!! Form::model($blog, ['method' => 'PATCH','route' => ['news.update', $blog->id], 'class' => 'forms-sample', 'enctype' => 'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                            {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview" class="img-fluid" src="{{asset('public/images/blog/'.$blog->image)}}" alt="your image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>{{__('News Category')}}</strong></label>
                            <select name="blog_cat_id" class="form-select" required>
                                @foreach ($blog_category as $data)
                                <option value="{{$data->id}}" @if($data->id == $blog->blog_cat_id) selected @endif>{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Title')}}</strong></label>
                            {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Description')}}</strong></label>
                            {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2">@lang('Update')</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

