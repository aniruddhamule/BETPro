@extends('admin.layouts.master')
@section('content')
<div class="row">
    @include('admin.user.user_sidebar')
    <div class="col-xl-8 col-lg-6 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('Transaction')}}</h4>
            </div>
            <div class="card-body p-0">
                <table class="table s7__table">
                    <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Details')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Remaining Balance')}}</th>
                        <th>{{__('Time')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($trx as $key => $data)
                        <tr>
                            <td>{{$trx->firstItem() + $key}}</td>
                            <td>{!! $data->title !!}</td>
                            <td>
                                @if($data->type == '+') <strong class="text-success"> +  {{$data->amount}} {{$general->currency}}</strong>
                                @elseif($data->type == '-') <strong class="text-danger"> -  {{$data->amount}} {{$general->currency}}</strong>
                                @elseif($data->type == '*') <strong class="text-info"> -  {{$data->amount}} {{$general->currency}}</strong>
                                @endif
                            </td>
                            <td><strong>{{$data->main_amo}} {{$general->currency}}</strong></td>
                            <td>{{date('d M, Y h:i A',strtotime($data->created_at))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                    {{$trx->links('pagination::bootstrap-4')}} 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection