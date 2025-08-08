@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('admin-users-index')
            <h4 class="card-title text-end"><button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn s7__btn-primary btn-sm">
                <i class="las la-plus"></i>
                {{__('Add User')}}
            </button></h4>
            @endcan
        </div>
        <div class="card-body">
            <table class="table s7__table">
                <thead>
                    <tr>
                        <th>{{__('No')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Email')}}</th>
                        <th>{{__('Roles')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                        <tr>
                            <td>{{$data->firstItem() + $key}}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge bg-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @can('admin-users-edit')
                                <a class="btn s7__btn-dark btn-sm" href="{{ route('admin-users.edit', $user->id) }}" title="Edit"><i class="las la-edit"></i></a>
                                @endcan
                                @can('admin-users-destroy')
                                {!! Form::open(['method' => 'DELETE', 'route' => ['admin-users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn s7__btn-danger btn-sm myDeletebtn'] )  }}
                                {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $data->render() !!}
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Modal title')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::open(array('route' => 'admin-users.store','method'=>'POST')) !!}
                <div class="modal-body">
                    <div class="row">
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
                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-select','multiple')) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn s7__btn-primary">{{__('Submit')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
