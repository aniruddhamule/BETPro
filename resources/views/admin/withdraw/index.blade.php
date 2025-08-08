@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                @can('withdraw-index')
                <form class="s7__nav-search-form" action="{{route('withdraw.index')}}" method="GET">
                    <input type="text" name="search" placeholder="Search..." autocomplete="off">
                    <button type="submit"><i data-feather="search"></i></button>
                </form>
                @endcan
                <div class="d-flex flex-wrap justify-content-end align-items-center">
                    @can('withdraw-create')
                        <h4 class="card-title text-end">
                        <a href="{{route('withdraw.create')}}" type="button" class="btn s7__btn-primary btn-sm">
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
                    <th>{{__('Method')}}</th>
                    <th>{{__('Method Name')}}</th>
                    <th>{{__('Currency')}}</th>
                    <th>{{__('Charge')}}</th>
                    <th>{{__('Rate')}}</th>
                    <th>{{__('Withdraw Limit')}}</th>
                    <th>{{__('Processing Time')}} </th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($withdraw as $key => $data)
                    <tr>
                        <td>{{$withdraw->firstItem() + $key}}</td>
                        <td><img class="gateway_image_size" src="{{asset('public/images/withdraw/'.$data->image)}}" alt="img"></td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->currency}}</td>
                        <td>{{ showAmount($data->chargefx)}} {{__($general->currency) }} {{ (0 < $data->chargepc) ? ' + '. showAmount($data->chargepc) .' %' : '' }}</td>
                        <td>{{$data->rate}}</td>
                        <td>{{ $data->min_amo + 0 }} - {{ $data->max_amo + 0 }} {{__($general->currency) }}</td>
                        <td>{{$data->processing_day}}</td>
                        <td>@if ($data->status == 1)
                            <span class="badge bg-success">{{__('Active')}}</span>
                            @else
                            <span class="badge bg-warning">{{__('Disabled')}}</span>
                            @endif</td>
                        <td>
                            @can('withdraw-edit')
                            <a href="{{route('withdraw.edit', $data->id)}}" class="btn s7__btn-dark btn-sm" title="Edit"><i class="las la-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$withdraw->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

@endsection

