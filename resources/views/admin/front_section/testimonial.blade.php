@extends('admin.layouts.master')
@section('content')
    
    <div class="card">
        <div class="card-header">
            @can('testimonial-create')
            <h4 class="card-title text-end"><button type="button" data-bs-toggle="modal" data-bs-target="#testimonialAddModel" class="btn btn-primary btn-sm">
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
                        <th>{{__('Image')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Designation')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonial as $key => $data)
                    <tr>
                        <td>{{$testimonial->firstItem() + $key}}</td>
                        <td><img src="{{asset('public/images/testimonial/'.$data->image)}}" alt="img"></td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->designation}}</td>
                        <td>
                            @can('testimonial-edit')
                            <a href="#editTestimonialModal" data-route="{{route('testimonial.update',$data->id)}}" data-bs-toggle="modal" data-name="{{$data->name}}" data-designation="{{$data->designation}}" 
                                title="Edit" data-image="{{asset('public/images/testimonial/'.$data->image)}}" class="btn btn-dark btn-sm editTestimonialBtn"><i class="las la-edit"></i></a>
                            @endcan
                            @can('testimonial-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['testimonial.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$testimonial->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade" id="testimonialAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Add New Testimonial')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'testimonial.store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
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
                    <label><strong>{{__('Name')}}</strong></label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Designation')}}</strong></label>
                    {!! Form::text('designation', null, array('placeholder' => 'Designation','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="editTestimonialModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Edit Testimonial')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['id' => 'editTestimonial', 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
            @csrf
            @method('put')
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                    {!! Form::file('image', array('id' => 'file-tstmnl-input2', 'class' => 'form-control')) !!}
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div id='img_contain2'>
                                <img id="image-preview2" class="img-fluid" src="" alt="your image"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>{{__('Name')}}</strong></label>
                    {!! Form::text('name', null, array('id' => 'editTstmnlName', 'placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Designation')}}</strong></label>
                    {!! Form::text('designation', null, array('id' => 'editTstmnlDesignation', 'placeholder' => 'Designation','class' => 'form-control')) !!}
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