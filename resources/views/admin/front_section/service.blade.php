@extends('admin.layouts.master')
@section('content')

    <div class="card">
        <div class="card-header">
            @can('service-create')
            <h4 class="card-title text-end"><button type="button" data-bs-toggle="modal" data-bs-target="#serviceAddModel" class="btn btn-primary btn-sm">
                    <i class="las la-plus"></i>
                {{__('Add New')}}
            </button></h4>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($service as $key => $data)
                    <tr>
                        <td>{{$service->firstItem() + $key}}</td>
                        <td>{{$data->title}}</td>
                        <td>
                            @can('service-edit')
                            <a href="#editServiceModal" data-route="{{route('service.update',$data->id)}}" data-bs-toggle="modal" data-description="{{$data->description}}" 
                                data-title="{{$data->title}}" data-image="{{asset('public/images/service/'.$data->image)}}" title="Edit" class="btn btn-dark btn-sm editServiceBtn"><i class="las la-edit"></i></a>
                            @endcan
                            @can('service-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['service.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$service->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade" id="serviceAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Add New Service')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'service.store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control', 'required')) !!}
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div id='img_contain'>
                                <img id="image-preview" class="img-fluid" src="{{asset('public/images/no-image.png')}}" alt="your image"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>{{__('Title')}}</strong></label>
                    {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Description')}}</strong></label>
                    {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Edit Service')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['id' => 'editService', 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong>
                    {!! Form::file('image', array('id' => 'file-service-input2', 'class' => 'form-control')) !!}
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div id='img_contain2'>
                                <img id="image-preview2" class="img-fluid" src="" alt="your image"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>{{__('Title')}}</strong></label>
                    {!! Form::text('title', null, array('id' => 'editServiceTitle', 'placeholder' => 'Title','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Description')}}</strong></label>
                    {!! Form::textarea('description', null, array('id' => 'editServiceDescription', 'class' => 'form-control')) !!}
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