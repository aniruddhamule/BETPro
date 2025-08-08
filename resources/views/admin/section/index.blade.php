@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('section-create')
            <h4 class="card-title text-end"><a href="{{route('section.create')}}" type="button" class="btn btn-primary btn-sm">
                    <i class="las la-plus"></i>
                {{__('Add New')}}
            </a></h4>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($section as $key => $data)
                    <tr>
                        <td>{{$section->firstItem() + $key}}</td>
                        <td><img class="gateway_image_size" src="{{asset('public/images/section/'.$data->image)}}" alt="img"></td>
                        <td>{{$data->title}}</td>
                        <td>
                            @can('section-edit')
                            <a href="{{route('section.edit', $data->id)}}" class="btn s7__btn-secondary btn-sm" title="Edit"><i class="las la-edit"></i></a>
                            @endcan
                            @can('section-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['section.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn s7__btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$section->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

@endsection

