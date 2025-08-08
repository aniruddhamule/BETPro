@extends('user.layouts.master')
@section('content')
<div class="leaderboard-area pd-bottom-150 bg-navy-2">
    <div class="container-sub">
        <div class="row">
            <div class="col-lg-12">
                <div class="leaderboard-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('SL')}}</th>
                                <th>{{__('Gateway Name')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Charge')}}</th>
                                <th>{{__('Method Cur Amount')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Transaction ID')}}</th>
                                <th>{{__('Time')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdraw as $key => $data)
                            <tr>
                                <td class="number">{{$key+1}}</td>
                                <td class="prediction-wrap">{{__($data->method_name)}}</td>
                                <td class="prediction-amount">{{round($data->amount, 8)}} {{$general->currency}}</td>
                                <td class="prediction-amount">{{round($data->charge, 8)}} {{$general->currency}}</td>
                                <td class="prediction-amount">{{round($data->amount*$data->method_rate, 8)}} {{$data->method_cur}}</td>
                                @if($data->status == 0)
                                    <td><span class="badge bg-warning">{{__('pending')}}</span></td>
                                @elseif($data->status == 1)
                                    <td><span class="badge bg-success">{{__('complete')}}</span></td>
                                @else
                                    <td><span class="badge bg-danger">{{__('rejected')}}</span></td>
                                @endif
                                <td>{{$data->withdraw_id}}</td>
                                <td class="prediction-time">{{$data->updated_at->format('d/m/y  h:i A')}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">{{__('No Data Found!')}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 text-center">
                <div class="py-4 pagination flex-wrap pagination-rounded-flat pagination-success">
                    {{$withdraw->links('pagination::bootstrap-4')}} 
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
