@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('permissions-create')
            <h4 class="card-title text-end"><button data-bs-toggle="modal" data-bs-target="#createModal" type="button" class="btn s7__btn-primary btn-sm">
                <i class="las la-plus"></i>
                {{__('Add Permission')}}
            </button>
            </h4>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Guard')}}</th> 
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($permissions as $key => $permission)
                    <tr>
                        <td>{{$permissions->firstItem() + $key}}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>
                        @can('permissions-edit')
                        <a class="btn s7__btn-secondary btn-sm" href="{{ route('permissions.edit', $permission->id) }}" title="Edit"><i class="las la-edit"></i></a>
                        @endcan
                        @can('permissions-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="ti-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                        @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="8">{{__('No Data Found!')}}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$permissions->links('pagination::bootstrap-4')}} 
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Permission Create')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label><strong>{{__('Name')}}:</strong></label>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection
