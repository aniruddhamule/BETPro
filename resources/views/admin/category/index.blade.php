@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <form class="s7__nav-search-form" action="{{route('category.index')}}" method="GET">
                <input type="text" name="search" placeholder="Search..." autocomplete="off">
                <button type="submit"><i data-feather="search"></i></button>
            </form>
            <div class="d-flex flex-wrap justify-content-end align-items-center">
                @can('category-create')
                    <h4 class="card-title text-end">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#categoryAddModel" class="btn s7__btn-primary btn-sm">
                    <i class="las la-plus"></i>
                    {{__('Add New')}}
                    </button></h4>
                @endcan
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table s7__table">
            <thead>
            <tr>
                <th>{{__('SL')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Icon')}}</th>
                <th>{{__('Status')}}</th>
                <th>{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($category as $key => $data)
                <tr>
                    <td>{{$category->firstItem() + $key}}</td>
                    <td>{{$data->name}}</td>
                    <td><i class="fas fa-{{$data->icon}}"></i></td>
                    <td>
                        @if ($data->status == 1)
                        <span class="badge bg-success">{{__('Active')}}</span>
                        @else
                        <span class="badge bg-warning">{{__('Disabled')}}</span>
                        @endif
                    </td>
                    <td>
                        @can('category-edit')
                        <a href="#editCategoryModal{{$data->id}}" data-bs-toggle="modal" class="btn s7__btn-secondary btn-sm" title="Edit"><i class="las la-edit"></i></a>
                        @endcan
                    </td>
                </tr>

                <div class="modal fade" id="editCategoryModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">{{__('Edit Category')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        {!! Form::model($data, ['method' => 'PATCH','route' => ['category.update', $data->id], 'enctype' => 'multipart/form-data']) !!}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label><strong>{{__('Name')}}</strong></label>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('Icon')}} <span class="text-danger">*</span></strong></label>
                                    {!! Form::text('icon', null, array('class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('Status')}}</strong></label>
                                    <select class="form-select" name="status">
                                        <option value="1" {{$data->status == 1?'selected':''}}>{{__('Active')}}</option>
                                        <option value="0" {{$data->status == 0?'selected':''}}>{{__('Inactive')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn s7__btn-primary">{{__('Update')}}</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
            {{$category->links('pagination::bootstrap-4')}} 
            </div>
    </div>
</div>

<div class="modal fade" id="categoryAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Add New Category')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'category.store', 'method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Name')}}</strong></label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Icon')}} <span class="text-danger">*</span></strong></label>
                    {!! Form::text('icon', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn s7__btn-primary">{{__('Submit')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

@endsection