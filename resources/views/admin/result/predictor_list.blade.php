@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-md-4">
                        {{$betQuestion->question}}
                    </div>
                    <div class="col-md-8 text-end">
                        <p>@if(!is_null($betQuestion->match->team_1_image))<img src="{{asset('public/images/match/'.$betQuestion->match->team_1_image)}}" alt="img">@endif {{$betQuestion->match->team_1}} <label class="badge bg-info"> {{__('VS')}} </label> @if(!is_null($betQuestion->match->team_2_image))<img src="{{asset('public/images/match/'.$betQuestion->match->team_2_image)}}" alt="img">@endif {{$betQuestion->match->team_2}}</p>

                    </div>
                </div>
            </h4>
        </div>

        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Username')}}</th>
                    <th>{{__('Threat')}}</th>
                    <th>{{__('Predict Amount')}}</th>
                    <th>{{__('Return Amount')}}</th>
                    <th>{{__('Time')}}</th>
                    <th>{{__('Status')}}</th>
                </tr>
                </thead>
                <tbody>
                @if(count($betInvest) > 0)
                    @foreach($betInvest as $key => $data)
                    <tr>
                        <td>{{$betInvest->firstItem() + $key}}</td>
                        <td><a href="{{route('user.view',$data->user_id)}}">
                            <strong>{{$data->user->name}}</strong>
                        </a></td>
                        <td><strong>{{$data->betoption->option_name}} </strong></td>
                        <td><strong class="text-success">{{number_format($data->invest_amount, $general->decimal)}} {{$general->currency}} </strong></td>
                        <td><strong class="text-danger">{{number_format($data->return_amount, $general->decimal)}} {{$general->currency}} </strong></td>
                        <td>{{date('d M Y h:i A',strtotime($data->created_at))}}</td>
                        <td>
                            @if($data->status ==-1)
                                <label class="badge bg-danger">{{__('Lose')}}</label>
                            @elseif($data->status ==1)
                                <label class="badge bg-success">{{__('win')}}</label>
                            @elseif($data->status ==0)
                                @can('admin-refundBetInvestSingleUser')
                                <button type="button"
                                        class="btn s7__btn-primary btn-sm refund_prelist_bet"
                                        title="Refund Prediction Amount"
                                        data-bs-toggle="modal" data-bs-target="#refundPrelistMyModal"
                                        data-act="Refund"
                                        data-id="{{$data->id}}">
                                    <i class="ti-na"></i>
                                </button>
                                @endcan
                            @elseif($data->status ==2)
                                <label class="badge bg-info">{{__('Refunded')}}</label>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7"><strong>{{__('No Data Found')}}!!</strong></td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$betInvest->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade" id="refundPrelistMyModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{__('Refund Amount Confirmation')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(array('route' => 'admin.refundBetInvestSingleUser', 'method'=>'POST')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <p>{{__('Are You want sure refund Amount')}}?</p>
                        <input class="form-control refund_prelist_id" type="hidden" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn s7__btn-danger" data-bs-dismiss="modal">{{__('No')}}</button>
                    <button type="submit" class="btn s7__btn-success">{{__('Yes')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

