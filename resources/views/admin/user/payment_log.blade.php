@extends('admin.layouts.master')
@section('content')
<div class="row">
    @include('admin.user.user_sidebar')
    <div class="col-xl-8 col-lg-6 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('Payment Log')}}</h4>
            </div>
            <div class="card-body p-0">
                <table class="table s7__table">
                    <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Trx')}}</th>
                        <th>{{__('Gateway')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Date')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment_logs as $key => $data)
                        <tr>
                            <td>{{$payment_logs->firstItem() + $key}}</td>
                            <td>
                                <a href="{{route('user.view', $data->user->id)}}">
                                    {{$data->user->name}}
                                </a>
                            </td>
                            <td>{{$data->trx}}</td>
                            <td>{{$data->gateway->name}}</td>
                            <td><strong>{{number_format($data->amount,2)}} {{$general->currency}}</strong></td>
                            <td>
                                @if($data->status == 2)
                                    <span class="badge badge-success">{{__('Completed')}}</span>
                                @elseif($data->status == -2)
                                    <span class="badge badge-danger">{{__('Rejected')}}</span>
                                @elseif($data->status == 1)
                                    <span class="badge badge-warning">{{__('Pending')}}</span>
                                @endif
                            </td>
                            <td>{{date('d M Y, h:i A',strtotime($data->updated_at))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                    {{$payment_logs->links('pagination::bootstrap-4')}} 
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection