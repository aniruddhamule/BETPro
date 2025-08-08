@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('roles-create')
            <h4 class="card-title text-end"><button data-bs-toggle="modal" data-bs-target="#createModal" type="button" class="btn s7__btn-primary btn-sm">
                <i class="las la-plus"></i>
                {{__('Add Role')}}
            </button></h4>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{$roles->firstItem() + $key}}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @can('roles-edit')
                                <a class="btn s7__btn-secondary btn-sm" href="{{ route('roles.edit',$role->id) }}" title="Edit"><i class="las la-edit"></i></a>
                            @endcan
                            @can('roles-destroy')
                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn s7__btn-danger btn-sm myDeletebtn'] )  }}
                                {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-12">
            {!! $roles->render() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Modal title')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label><strong>{{__('Name')}}:</strong></label>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="form-group text-center">
                                    <h4><strong>{{__('Permission')}}</strong></h4>
                                </div>
                                <hr/>
                                @foreach($permission as $value)
                                <div class="col-md-3">
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                </div>
                                <br/>
                                @endforeach
                            </div>
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
