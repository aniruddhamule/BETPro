@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('slider-create')
            <h4 class="card-title text-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#sliderAddModel" class="btn btn-primary btn-sm">
                    <i class="las la-plus"></i>
                {{__('Add New')}}
                </button>
            </h4>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($slider as $key => $data)
                    <tr>
                        <td>{{$slider->firstItem() + $key}}</td>
                        <td><img  class="gateway_image_size" src="{{asset('public/images/slider/'.$data->image)}}" alt="img"></td>
                        <td>
                            @if ($data->status == 1)
                            <span class="badge bg-success">{{__('Active')}}</span>
                            @else
                            <span class="badge bg-warning">{{__('Disabled')}}</span>
                            @endif
                        </td>
                        <td>
                            @can('slider-edit')
                            <a href="#editSliderModal{{$data->id}}" data-bs-toggle="modal" class="btn s7__btn-secondary btn-sm" title="Edit"><i class="las la-edit"></i></a>
                            @endcan
                            @can('slider-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['slider.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>

                    <div class="modal fade" id="editSliderModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">{{__('Edit Slider')}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            {!! Form::model($data, ['method' => 'PATCH','route' => ['slider.update', $data->id], 'enctype' => 'multipart/form-data']) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                                        {!! Form::file('image', array('id' => 'file-input2', 'class' => 'form-control')) !!}
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div id='img_contain'>
                                                    <img id="image-preview2" class="img-fluid" src="{{asset('public/images/slider/'.$data->image)}}" alt="your image"/>
                                                </div>
                                            </div>
                                        </div>
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
                                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$slider->links('pagination::bootstrap-4')}} 
            </div>
        </div>
    </div>

    <div class="modal fade" id="sliderAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{__('Add New Slider')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(array('route' => 'slider.store', 'method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
        </div>
    </div>

@endsection