@extends('admin.layouts.master')
@section('content')

    <div class="card">
        {!! Form::model($general, array('route' => 'general.store',$general->id, 'class' => 'forms-sample', 'method' => 'POST')) !!}
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="form-group">
                        <label><strong>{{__('Address')}}</strong></label>
                        {!! Form::text('contact_address', null, array('placeholder' => 'Address','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('Email')}}</strong></label>
                        {!! Form::text('contact_email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('Phone')}}</strong></label>
                        {!! Form::text('contact_phone', null, array('placeholder' => 'Phone','class' => 'form-control')) !!}
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection