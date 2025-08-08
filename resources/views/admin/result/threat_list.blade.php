@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Thread')}}</th>
                        <th>{{__('Ratio')}}</th>
                        <th>{{__('Total Predict Amount')}}</th>
                        <th>{{__('Total Return Amount')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($betoption) > 0)
                    @foreach($betoption as $key => $data)
                    <tr>
                        <td>{{$betoption->firstItem() + $key}}</td>
                        <td>{!! $data->option_name !!}</td>
                        <td><strong>{!! $data->ratio1	 !!} x {!! $data->ratio2 !!}</strong></td>
                        <td><a href="{{route('admin.bet-option-userlist',$data->id)}}" data-tooltip-content="Predictor List">
                                <strong class="text-success">{{number_format($data->investAmo(),2)}} {{$general->currency}} </strong>
                            </a>
                        </td>
                        <td><strong class="text-danger">{{number_format($data->giveBackAmo(),2)}} {{$general->currency}} </strong></td>
                        <td>
                            @if($data->status ==1)
                                <label class="badge bg-warning">{{__('Pending')}}</label>
                            @elseif($data->status ==2)
                                <label class="badge bg-success">{{__('win')}}</label>
                            @elseif($data->status ==0)
                                <label class="badge bg-info">{{__('DeActive')}}</label>
                            @elseif($data->status ==-2)
                                <label class="badge bg-danger">{{__('Lost')}}</label>
                            @elseif($data->status ==3)
                                <label class="badge bg-success">{{__('Refunded')}}</label>
                            @endif
                        </td>
                        <td>
                            @if(($data->status == 0) or ($data->status == 1))
                                @can('admin-make-winner')
                                <button type="button"
                                    class="edit_threat_btn btn s7__btn-primary btn-sm btn-rounded"
                                    title="Make Winner"
                                    data-bs-toggle="modal" data-bs-target="#myThreatModal"
                                    data-act=""
                                    data-id="{{$data->id}}"
                                    data-ques_id="{{$ques->id}}"
                                    data-matchid="{{$data->match->id}}">
                                    <i class="las la-trophy"></i>
                                </button>
                                @endcan
                            @elseif($data->status ==2 || $data->status == -2 || $data->status == 3)
                                <label class="badge bg-success">{{__('Completed')}}</label>
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
                {{$betoption->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade" id="myThreatModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel"><b class="subro_act"></b> {{__(' Make Winner')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(array('route' => 'admin.make.winner', 'method'=>'POST')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <p>{{__('Are you sure want to Make winner this')}}?</p>
                        <input type="hidden" name="betoption_id" class="threat_id" >
                        <input type="hidden" name="match_id" class="threat_match_id">
                        <input type="hidden" name="ques_id" class="threat_ques_id">
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