@extends('admin.layouts.master')
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <form class="s7__nav-search-form" action="{{route('news.search')}}" method="GET">
                    <input type="text" name="title" placeholder="Search..." autocomplete="off">
                    <button type="submit"><i data-feather="search"></i></button>
                </form>
                <div class="d-flex flex-wrap justify-content-end align-items-center">
                    @can('news-create')
                        <h4 class="card-title text-end">
                        <a href="{{route('news.create')}}" type="button" class="btn s7__btn-primary btn-sm">
                            <i class="las la-plus"></i>
                        {{__('Add New')}}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{('SL')}}</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($blog as $key => $data)
                    <tr>
                        <td>{{$blog->firstItem() + $key}}</td>
                        <td><img class="gateway_image_size" src="{{asset('public/images/blog/'.$data->image)}}" alt="img"></td>
                        <td>{{$data->title}}</td>
                        <td>
                            @can('news-edit')
                            <a href="{{route('news.edit', $data->id)}}" class="btn btn-dark btn-rounded btn-sm"><i class="las la-edit"></i></a>
                            @endcan
                            @can('news-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['news.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-rounded btn-sm myDeletebtn'] )  }}
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
                {{$blog->links('pagination::bootstrap-4')}} 
            </div>
        </div>
    </div>

@endsection

