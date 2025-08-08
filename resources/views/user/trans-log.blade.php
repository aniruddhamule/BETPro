@extends('user.layouts.master')
@section('content')
<div class="leaderboard-area pd-bottom-60 bg-navy-2">
    <div class="container-sub">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card card-body leaderboard-area-cus leaderboard-table">
                    <form class="row mb-4 mt-5" action="{{route('search.trans.user')}}" method="Get">
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Search Via Trans ID" name="trans_id" value="{{isset(request()->trans_id) ? request()->trans_id: '' }}">
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" name="type">
                                <option {{isset(request()->type) && (request()->type == 'All') ? 'selected': '' }} value="All">{{__('All Transactions')}}</option>
                                <option {{isset(request()->type) && (request()->type == 'Invest') ? 'selected': '' }} value="Invest">{{__('Invest')}}</option>
                                <option {{isset(request()->type) && (request()->type == 'Deposit') ? 'selected': '' }} value="Deposit">{{__('Deposit')}}</option>
                                <option {{isset(request()->type) && (request()->type == 'Withdraw') ? 'selected': '' }} value="Withdraw">{{__('Withdraw')}}</option>
                                <option {{isset(request()->type) && (request()->type == 'Referral') ? 'selected': '' }} value="Referral">{{__('Referral')}}</option>
                                <option {{isset(request()->type) && (request()->type == 'Predict') ? 'selected': '' }} value="Predict">{{__('Predict')}}</option>
                                <option {{isset(request()->type) && (request()->type == 'Game') ? 'selected': '' }} value="Game">{{__('Game')}}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                          <button type="submit" class="btn btn-blue btn-custm mb-3 btn-sm btn-block">{{__('Search')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="leaderboard-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('SL')}}</th>
                                <th> {{__('Trans ID')}} </th>
                                <th> {{__('Details')}} </th>
                                <th> {{__('Amount')}} </th>
                                <th> {{__('Old Balance')}} </th>
                                <th> {{__('New Balance')}} </th>
                                <th> {{__('Type')}} </th>
                                <th> {{__('Time')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trans as $key => $data)
                            <tr>
                                <td class="number">{{$key+1}}</td>
                                <td class="prediction-wrap">{{$data->trans_id}}</td>
                                <td class="prediction-amount">{{__($data->description)}}</td>
                                <td class="prediction-amount">{{$data->amount}}{{$general->currency}}</td>
                                <td class="prediction-amount">{{$data->old_bal}}{{$general->currency}}</td>
                                <td class="prediction-amount">{{$data->new_bal}}{{$general->currency}}</td>
                                <td class="prediction-amount">
                                    @if($data->status == 0)
                                        <span class="badge bg-primary">{{__('Invest')}}</span>
                                    @elseif($data->status == 1)
                                        <span class="badge bg-success">{{__('Deposit')}}</span>
                                    @elseif($data->status == 2)
                                        <span class="badge bg-info">{{__('Transfer')}}</span>
                                    @elseif($data->status == 3)
                                        <span class="badge bg-dark">{{__('Withdraw')}}</span>
                                    @elseif($data->status == 5)
                                    <span class="badge bg-secondary">{{__('Referral Commission')}}</span>
                                    @elseif($data->status == 6)
                                    <span class="badge bg-warning">{{__('Predict Win')}}</span>
                                    @elseif($data->status == 4)
                                    <span class="badge bg-warning">{{__('Predict')}}</span>
                                    @elseif($data->status == 10)
                                    <span class="badge bg-success">{{__('Game')}}</span>
                                    @else
                                        <span class="badge bg-warning">{{__('Income')}}</span>
                                    @endif
                                </td>
                                <td class="prediction-time">{{date('d/m/y  h:i A',strtotime($data->created_at))}}</td>
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
                    {{$trans->links('pagination::bootstrap-4')}}
                 </div>
            </div>
        </div>
    </div>
</div>

@endsection
