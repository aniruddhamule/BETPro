@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Question')}}</th>
                    <th>{{__('Event')}}</th>
                    <th>{{__('End Time')}}</th>
                    <th>{{__('Predictors')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $key => $data)
                    <tr>
                        <td>{{$questions->firstItem() + $key}}</td>
                        <td><strong>{{$data->question}}</strong></td>
                        <td>@if(!is_null($data->match->team_1_image))<img src="{{asset('public/images/match/'.$data->match->team_1_image)}}" alt="img">@endif {{$data->match->team_1}} <label class="badge bg-info"> {{__('VS')}} </label> @if(!is_null($data->match->team_2_image))<img src="{{asset('public/images/match/'.$data->match->team_2_image)}}" alt="img">@endif {{$data->match->team_2}}</td>
                        <td>{{(date('d M Y h:i A',strtotime($data->end_time)))}}</td>
                        <td>
                            @can('admin-awaiting-winner-userlist')
                            <a href="{{route('admin.awaiting.winner.userlist',$data->id)}}" class="btn s7__btn-primary btn-sm">{{$data->totalInvestor()}}</a>
                            @endcan
                        </td>
                        <td>
                            @if($data->result == 1)
                                @can('admin-view-option-endtime')
                                <a href="{{route('admin.view.option.endtime',$data->id)}}"
                                    class="btn s7__btn-success btn-sm"
                                    title="View Winner">
                                    <i class="las la-trophy"></i>
                                </a>
                                @endcan

                            @else
                                @can('admin-view-option-endtime')
                                <a href="{{route('admin.view.option.endtime',$data->id)}}"
                                    class="btn s7__btn-secondary btn-sm"
                                    title="Select Winner">
                                    <i class="las la-trophy"></i>
                                </a>
                                @endcan
                                @can('admin-update-question')
                                <button type="button"
                                        class="edit_awaiting_ques btn s7__btn-info btn-sm"
                                        title="Update Question"
                                        data-bs-toggle="modal" data-bs-target="#EditAwaitingModal"
                                        data-act="Edit"
                                        data-matchenddate="{{date('d M, Y H:i',strtotime($data->match->end_date))}}"
                                        data-name="{{$data->question}}"
                                        data-datetime="{{date('H:i',strtotime($data->end_time))}}"
                                        data-enddate="{{date('m/d/Y',strtotime($data->end_time))}}"
                                        data-status="{{$data->status}}"
                                        data-id="{{$data->id}}"
                                        data-mid="{{$data->match_id}}">
                                        <i class="las la-question"></i>
                                </button>
                                @endcan
                                @can('admin-refundbetinvest')
                                <button type="button"
                                        class="refund_bet btn s7__btn-danger btn-sm"
                                        title="Refund Prediction Amount"
                                        data-bs-toggle="modal" data-bs-target="#refundMyModal"
                                        data-id="{{$data->id}}"
                                        data-mid="{{$data->match_id}}">
                                    <i class="las la-times"></i>
                                </button>
                                @endcan
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$questions->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

 <div class="modal fade" id="EditAwaitingModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title modal_awaiting_act" id="ModalLabel">{{__('Edit Questions')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(array('route' => 'admin.update.question', 'method'=>'POST')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label><strong>{{__('Question')}}</strong></label>
                        <input class="form-control input-lg edit_awaiting_question" name="question" type="text" required>
                        <input class="form-control edit_awaiting_id" type="hidden" name="id">
                        <input class="form-control input-lg edit_awaiting_match_id" name="match_id"  type="hidden" >
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label><strong>{{__('End Date')}}</strong></label>
                            <div class="input-group date">
                                <input type="text" id="pickupDate" class="form-control edit_awaiting_date datepicker-field" data-language="en"
                                    data-position='bottom left' name="end_date" autocomplete="off">
                                <span class="input-group-addon input-group-text"><span class="fa fa-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label><strong>{{__('End Time')}}</strong></label>
                            {!! Form::time('end_time', date('H:i'), array('placeholder' => 'end_time','class' => 'form-control edit_awaiting_time')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="text-danger">{{__('This Date & Time will working  Before')}} <span class="awaiting_match_end_date"></span></p>
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('Status')}}</strong></label>
                        <select class="form-select edit_awaiting_status" name="status" required>
                            <option value="1">{{__('Active')}}</option>
                            <option value="0">{{__('Inactive')}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">{{__('Update')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="refundMyModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">{{__('Refund Prediction Amount')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'admin.refundBetInvest', 'method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <p>{{__('Are You want sure refund Amount')}}?</p>
                    <input class="form-control refund_id" type="hidden" name="question_id">
                    <input class="form-control input-lg refund_match_id" name="match_id" type="hidden">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('No')}}</button>
                <button type="submit" class="btn btn-success">{{__('Yes')}}</button>
            </div>
        {!! Form::close() !!}
    </div>
    </div>
</div>

@endsection

