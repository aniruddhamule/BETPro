@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('advertise-create')
                <h4 class="card-title text-end"><a href="{{route('advertise.create')}}" type="button" class="btn btn-primary btn-sm">
                        <i class="las la-plus"></i>
                    {{__('Add New')}}
                </a></h4>
            @endcan
        </div>
        <div class="card-body p-0">
            @if($session == 'banner')
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Banner')}}</th>
                    <th>{{__('Redirect URL')}}</th>
                    <th>{{__('Click')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($advertise as $key => $data)
                    <tr>
                        <td>{{$advertise->firstItem() + $key}}</td>
                        <td><img class="gateway_image_size" src="{{asset('public/images/advertise/'.$data->image)}}" alt="image"></td>
                        <td><a href="{{$data->image_redirect_url}}">{{$data->image_redirect_url}}</a></td>
                        <td>{{$data->clicks}}</td>
                        <td>
                            @can('advertise-edit')
                            <a href="{{route('advertise.edit', $data->id)}}" title="Edit" class="btn s7__btn-secondary btn-sm"><i class="las la-edit"></i></a>
                            @endcan
                            @can('advertise-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['advertise.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn s7__btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$advertise->links('pagination::bootstrap-4')}} 
            </div>
            @elseif($session == 'script')
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Script')}}</th>
                    <th>{{__('Click')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($advertise as $key => $data)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$data->script}}</td>
                        <td>{{$data->clicks}}</td>
                        <td>
                            @can('advertise-edit')
                            <a href="{{route('advertise.edit', $data->id)}}" class="btn btn-dark btn-sm"><i class="las la-edit"></i></a>
                            @endcan
                            @can('advertise-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['advertise.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$advertise->links('pagination::bootstrap-4')}} 
                </div>
            @endif
        </div>
    </div>
@endsection

