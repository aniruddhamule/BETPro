@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                @can('admin-manual-gateway')
                <form class="s7__nav-search-form" action="{{route('admin.manual.gateway')}}" method="GET">
                    <input type="text" name="search" placeholder="Search..." autocomplete="off">
                    <button type="submit"><i data-feather="search"></i></button>
                </form>
                @endcan
                <div class="d-flex flex-wrap justify-content-end align-items-center">
                    @can('category-create')
                        <h4 class="card-title text-end">
                        <a href="{{route('gateway.create')}}" type="button" class="btn s7__btn-primary btn-sm">
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
                    <th>{{__('SL')}}</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Gateway')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($gateway as $key => $data)
                        <tr>
                            <td>{{$gateway->firstItem() + $key}}</td>
                            <td><img class="gateway_image_size" src="{{asset('public/images/gateway/'.$data->image)}}" alt="img"></td>
                            <td>{{$data->name}}</td>
                            <td>@if ($data->status == 1)
                                <span class="badge bg-success">{{__('Active')}}</span>
                                @else
                                <span class="badge bg-warning">{{__('Disabled')}}</span>
                                @endif</td>
                            <td>
                                @can('gateway-edit')
                                <a href="{{route('gateway.edit', $data->id)}}" class="btn btn-dark btn-sm" title="Edit"><i class="las la-edit"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$gateway->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>
@endsection

