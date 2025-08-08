@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('TRX')}}</th>
                    <th>{{__('Amount Of Withdraw')}}</th>
                    <th>{{__('Method')}}</th>
                    <th>{{__('Amount In Method')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($withdrawLog as $key => $data)
                    <tr>
                        <td>{{$withdrawLog->firstItem() + $key}}</td>
                        <td>{{optional($data->user)->name}}</td>
                        <td>{{$data->transaction_id}}</td>
                        <td>{{number_format($data->amount,2)}} {{$general->currency}}</td>
                        <td><b>{{$data->method_name}}</b></td>
                        <td>{{round(floatval($data->amount)*floatval($data->method_rate), 4)}} {{$data->method_cur}}</td>
                        <td>
                            @if($data->status == 0)
                                <span class="badge bg-warning">{{__('Pending')}}</span>
                            @elseif($data->status == 1)
                                <span class="badge bg-success">{{__('Paid')}}</span>
                            @else
                                <span class="badge bg-danger">{{__('Refunded')}}</span>
                            @endif
                        </td>
                        <td>
                            @can('admin-withdraw-detail')
                            <a href="{{route('admin.withdraw.detail', $data->id)}}" class="btn s7__btn-primary btn-sm">{{__('Action')}}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$withdrawLog->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

@endsection

