@extends('admin.layouts.master')
@section('content')
<div class="row">
    @include('admin.user.user_sidebar')
    <div class="col-xl-8 col-lg-6 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('Prediction Log')}}</h4>
            </div>
            <div class="card-body p-0">
                <table class="table s7__table">
                    <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Event')}}</th>
                        <th>{{__('Question')}}</th>
                        <th>{{__('Threat')}}</th>
                        <th>{{__('Predict Amount')}}</th>
                        <th>{{__('Return Amount')}}</th>
                        <th>{{__('Available Balance')}}</th>
                        <th>{{__('Ratio')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Predict Time')}}</th>
                        <th>{{__('Result Time')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedict_logs as $key => $data)
                        <tr>
                            <td>{{$pedict_logs->firstItem() + $key}}</td>
                            <td><img src="{{asset('public/images/match/'.$data->match->team_1_image)}}" alt="img"> {{$data->match->team_1}} <label class="badge badge-info"> {{__('VS')}} </label> <img src="{{asset('public/images/match/'.$data->match->team_2_image)}}" alt="img"> {{$data->match->team_2}}</td>
                            <td>{{$data->ques->question}}</td>
                            <td>{{$data->betoption->option_name}}</td>
                            <td>{{$data->invest_amount}} {{__($general->currency)}}</td>
                            <td>{{$data->return_amount}} {{__($general->currency)}}
                                <br>
                                @if($data->status == 1)  <span class="badge badge-danger">({{__('Charge')}}
                                    : {{$data->charge}}  {{__($general->currency)}})</span> @endif
                            </td>
                            <td>
                                @if($data->remaining_balance != null)
                                    {{round($data->remaining_balance,2)}} {{__($general->currency)}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{$data->ratio}}</td>
                            <td>
                                @if($data->status == 1)
                                    <span class="badge badge-success">{{__('Win')}}</span>
                                @elseif($data->status == -1)
                                    <span class="badge badge-danger">{{__('Lose')}}</span>
                                @elseif($data->status == 2)
                                    <span class="badge badge-primary">{{__('Refunded')}}</span>
                                @else
                                    <span class="badge badge-warning">{{__('Processing')}}</span>
                                @endif
                            </td>
                            <td>{{date('h:i A',strtotime($data->created_at))}}</td>
                            <td>
                                @if($data->status  == 0)
                                    <label class="badge badge-warning">{{__('Processing')}}</label>
                                @else
                                    {{date('d M Y h:i A',strtotime($data->updated_at))}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                    {{$pedict_logs->links('pagination::bootstrap-4')}} 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection