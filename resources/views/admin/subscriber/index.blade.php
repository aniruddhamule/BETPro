@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('subscriber-create')
            <h4 class="card-title text-end"><a href="{{route('subscriber.create')}}" type="button" class="btn s7__btn-primary btn-sm">
                {{__('Send Email')}}
            </a></h4>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Joined')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($subscribers as $key => $data)
                    <tr>
                        <td>{{$subscribers->firstItem() + $key}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{ dateTime($data->created_at) }}</td>
                        <td>
                            @can('subscriber-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['subscriber.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn s7__btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$subscribers->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>
@endsection

