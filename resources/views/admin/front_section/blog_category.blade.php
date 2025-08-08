@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('news-category-create')
            <h4 class="card-title text-end"><button type="button" data-bs-toggle="modal" data-bs-target="#blogCatAddModel" class="btn btn-primary btn-sm">
                    <i class="las la-plus"></i>
                {{__('Add New')}}
            </button></h4>
        </div>
        @endcan
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
                    @foreach ($category as $key => $data)
                    <tr>
                        <td>{{$category->firstItem() + $key}}</td>
                        <td>{{$data->name}}</td>
                        <td>
                            @can('news-category-edit')
                            <a href="#editBlogCatModal" data-route="{{route('news-category.update',$data->id)}}" data-bs-toggle="modal" data-name="{{$data->name}}" 
                                title="Edit" class="btn btn-dark btn-sm editBlogCatBtn"><i class="las la-edit"></i></a>
                            @endcan
                            @can('news-category-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['news-category.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$category->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade" id="blogCatAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Add New News Category')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'news-category.store', 'method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Name')}}</strong></label>
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

<div class="modal fade" id="editBlogCatModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Edit News Category')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['id' => 'editBlogCat', 'method' => 'PATCH']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Name')}}</strong></label>
                    {!! Form::text('name', null, array('id' => 'editBlogName', 'placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

@endsection