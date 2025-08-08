@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(array('route' => 'admin.subscriber.mail', 'class' => 'forms-sample', 'method' => 'POST')) !!}
                <div class="form-group">
                    <label><strong>{{__('Subject')}}</strong></label>
                    {!! Form::text('subject', null, array('placeholder' => 'Write Subject','class' => 'form-control')) !!}
                </div>
                <div class="form-group ">
                    <label><strong>{{__('Message')}}</strong></label>
                    {!! Form::textarea('message', null, array('class' => 'form-control', 'row' => '15')) !!}
                </div>
                <div class="submit-btn-wrapper mt-md-3 text-center text-md-left">
                    <button type="submit" class="btn btn-rounded btn-primary">{{__('Send Email')}} </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

