@extends('admin.layouts.master')
@section('content')
    <div class="card">
        {!! Form::open(array('route' => 'extra-page.store', 'class' => 'forms-sample', 'method' => 'POST')) !!}
            <div class="card-body">
                <div class="row">
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
                    <button type="submit" class="btn s7__btn-primary mt-3 me-2">{{__('Submit')}}</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

