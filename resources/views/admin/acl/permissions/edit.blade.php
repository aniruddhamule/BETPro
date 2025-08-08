@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
        {!! Form::model($permission, ['method' => 'PATCH','route' => ['permissions.update', $permission->id]]) !!}
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="form-group mb-2">
                    <label><strong>{{__('Name')}}:</strong></label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <button type="submit" class="btn s7__btn-primary">{{__('Update')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
        </div>
    </div>
@endsection
