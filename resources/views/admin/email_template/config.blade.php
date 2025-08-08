@extends('admin.layouts.master')
@section('content')
    <div class="card">
        {!! Form::model($general, array('route' => 'admin.email-controls.update',$general->id, 'class' => 'forms-sample', 'method' => 'POST')) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('From Email')}}</strong></label>
                        {!! Form::text('sender_email', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('From Email Name')}}</strong></label>
                        {!! Form::text('sender_email_name', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group d-none">
                    <label><strong>{{__('Send Email Method')}}</strong></label>
                    <select name="email_method" class="form-select">
                        <option value="sendmail" @if(old('email_method', @$general->email_configuration->name) == "sendmail")  selected @endif>{{__('PHP Mail')}}</option>
                        <option value="smtp" @if( old('email_method', @$general->email_configuration->name) == "smtp") selected @endif>{{__('SMTP')}}</option>
                    </select>
                </div>
            </div>
            <div class="row d-none configForm" id="smtp">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Host')}} <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" placeholder="{{__('Host or Email Address')}}" name="smtp_host" value="{{ old('smtp_host', $general->email_configuration->smtp_host ?? '') }}"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Port')}} <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" placeholder="{{__('Available port')}}" name="smtp_port" value="{{ old('smtp_port', $general->email_configuration->smtp_port ?? '') }}"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Encryption')}} <span class="text-danger">*</span></strong></label>
                        <select name="smtp_encryption" class="form-select">
                            <option value="tls" @if( old('smtp_encryption', @$general->email_configuration->smtp_encryption) == "tls") selected @endif>{{__('TLS')}}</option>
                            <option value="ssl" @if( old('smtp_encryption', @$general->email_configuration->smtp_encryption) == "ssl") selected @endif>{{__('SSL')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('Username')}} <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" placeholder="{{__('username or Email')}}" name="smtp_username" value="{{ old('smtp_username', $general->email_configuration->smtp_username ?? '') }}"/>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('Password')}} <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" placeholder="{{__('Password')}}" name="smtp_password" value="{{ old('smtp_password', $general->email_configuration->smtp_password ?? '') }}"/>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection