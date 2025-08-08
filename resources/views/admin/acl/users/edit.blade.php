@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
        {!! Form::model($user, ['method' => 'PATCH','route' => ['admin-users.update', $user->id]]) !!}
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="form-group">
                    <label><strong>{{__('Name')}}:</strong></label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Email')}}:</strong></label>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Password')}}:</strong></label>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Confirm Password')}}:</strong></label>
                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Role')}}:</strong></label>
                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-select','multiple')) !!}
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn s7__btn-primary">{{__('Update')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
        </div>
    </div>

@endsection
