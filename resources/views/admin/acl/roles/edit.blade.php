@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="form-group mb-4">
                        <label><strong>{{__('Name')}}:</strong></label>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group text-center">
                    <h4><strong>{{__('Permission')}}</strong></h4>
                </div>
                <hr/>
                @foreach($permission as $value)
                <div class="col-md-3">
                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                    {{ $value->name }}</label>
                </div>
                <br/>
                @endforeach
                <div class="text-center">

                    <button type="submit" class="btn s7__btn-primary">{{__('Update')}}</button>
                </div>
            </div>
                    
            {!! Form::close() !!}
        </div>
    </div>
@endsection
