@extends('admin.layouts.master')
@section('content')
    @can('withdraw_log-search')
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{route('withdraw_log.search')}}">
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
                    <th>{{__('User')}}</th>
                    <th>{{__('TRX')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Charge')}}</th>
                    <th>{{__('Method')}}</th>
                    <th>{{__('Details')}}</th>
                    <th>{{__('Requested On')}}</th>
                    <th>{{__('Processed On')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($withdrawLog as $key => $data)
                    <tr class="@if($data->status == 2) danger @elseif($data->status == 1) success @else warning @endif">
                        <td>{{$withdrawLog->firstItem() + $key}}</td>
                        <td><p><a href="{{route('user.view', $data->user->id)}}">{{$data->user->name}}</a> </p>
                            <p>{{$data->user->email}}</p></td>
                        <td>{{$data->withdraw_id}}</td>
                        <td>{{number_format($data->amount,2)}} {{$general->currency}}</td>
                        <td>{{$data->charge}} {{$general->currency}}</td>
                        <td>{{$data->method_name}}</td>
                        <td>
                            @can('admin-withdraw-detail')
                            <a type="button" class="btn btn-sm s7__btn-info" href="{{route('admin.withdraw.detail',$data->id)}}">{{__('View Details')}}</a>
                            @endcan
                        </td>
                        <td>{{date('g:ia \o\n l jS F Y', strtotime($data->created_at))}}</td>
                        <td>{{date('g:ia \o\n l jS F Y', strtotime($data->updated_at))}}</td>
                        <td>
                            @if($data->status == 2)
                                <span class="badge bg-danger">{{__('REFUNDED')}}</span>
                            @elseif($data->status == 1)
                                <span class="badge bg-success">{{__('PAID')}}</span>
                            @else
                                <span class="badge bg-warning">{{__('PENDING')}}</span>
                            @endif
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

