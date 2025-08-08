@extends('admin.layouts.master')
@section('content')
    @can('deposit_log-search')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{route('deposit_log.search')}}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group date">
                            <input type="text" class="form-control startDate" name="start_date" />
                            <span class="input-group-addon input-group-text"><span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group date">
                            <input type="text" class="form-control endDate" name="end_date" />
                            <span class="input-group-addon input-group-text"><span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <Button class="btn s7__btn-primary" type="submit">{{__('Search')}}</Button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endcan
    
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Gateway Name')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Charge')}}</th>
                    <th>{{__('USD Amount')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Transaction ID')}}</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($deposits as $key => $data)
                    <tr>
                        <td>{{$deposits->firstItem() + $key}}</td>
                        <td><a target="_blank" href="{{route('user.view', $data->user_id)}}">{{$data->user->name}}</a></td>
                        <td>{{($data->gateway->main_name)?$data->gateway->main_name:$data->gateway->name}}</td>
                        <td>{{round($data->amount, 8)}} {{$general->currency}}</td>
                        <td>{{round($data->charge, 8)}} {{$general->currency}}</td>
                        <td>{{round($data->usd_amo, 8)}} {{$general->currency}}</td>
                        <td>
                            @if(isset($data->deposit_request_table) && !is_null($data->deposit_request_table))
                                @if($data->deposit_request_table->status == 0)
                                    <span class="badge bg-warning">{{__('pending')}}</span>
                                @elseif($data->deposit_request_table->status == 1)
                                    <span class="badge bg-success">{{__('approved')}}</span>
                                @else
                                    <span class="badge bg-danger">{{__('rejected')}}</span>
                                @endif
                            @else
                                @if($data->status == 0)
                                    <span class="badge bg-danger">{{__('incomplete')}}</span>
                                @else
                                    <span class="badge bg-success">{{__('Complete')}}</span>
                                @endif
                            @endif
                        </td>
                        <td>{{$data->trx}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$deposits->links('pagination::bootstrap-4')}} 
            </div>
        </div>
    </div>
@endsection

