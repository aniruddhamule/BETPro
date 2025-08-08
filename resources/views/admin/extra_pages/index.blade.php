@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('extra-page-create')
            <h4 class="card-title text-end"><a href="{{route('extra-page.create')}}" type="button" class="btn s7__btn-primary btn-sm">
                    <i class="las la-plus"></i>
                {{__('Add New')}}
            </a></h4>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                    <tr>
                        <th>{{__('Sl')}}</th>
                        <th>{{__('Title')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($extra_page as $key => $data)
                    <tr>
                        <td>{{$extra_page->firstItem() + $key}}</td>
                        <td>{{$data->title}}</td>
                        <td>
                            @can('extra-page-edit')
                            <a href="{{route('extra-page.edit', $data->id)}}" title="Edit" class="btn s7__btn-secondary btn-sm"><i class="las la-edit"></i></a>
                            @endcan
                            @can('extra-page-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['extra-page.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn s7__btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$extra_page->links('pagination::bootstrap-4')}} 
            </div>
        </div>
    </div>

@endsection

