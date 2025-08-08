@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::model($extra_page, ['method' => 'PATCH','route' => ['extra-page.update', $extra_page->id], 'class' => 'forms-sample']) !!}
                <div class="row">
                    <div class="form-group">
                        <label><strong>{{__('Title')}}</strong></label>
                        {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('Description')}}</strong></label>
                        {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Update')}}</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

