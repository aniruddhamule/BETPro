@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-md-4">
                        {{$betoption->question->question }}
                        <small class="text-success">({{$betoption->option_name}})</small>
                    </div>
                    <div class="col-md-8 text-end">
                        <p>@if(!is_null($betoption->question->match->team_1_image))<img class="bet-flag-img" src="{{asset('public/images/match/'.$betoption->question->match->team_1_image)}}" alt="img">@endif {{$betoption->question->match->team_1}} <label class="badge bg-info"> {{__('VS')}} </label> @if(!is_null($betoption->question->match->team_2_image))<img class="bet-flag-img" src="{{asset('public/images/match/'.$betoption->question->match->team_2_image)}}" alt="img">@endif {{$betoption->question->match->team_2}}</p>
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
                        <th>{{__('Predict Amount')}}</th>
                        <th>{{__('Return Amount')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Time')}}</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($betInvest) > 0)
                    @foreach($betInvest as $key => $data)
                    <tr>
                        <td>{{$betInvest->firstItem() + $key}}</td>
                        <td><a href="{{route('user.view',$data->user_id)}}">
                            <strong>{{$data->user->name}} </strong>
                        </a></td>
                        <td><strong class="text-success">{{number_format($data->invest_amount, $general->decimal)}} {{$general->currency}} </strong></td>
                        <td><strong class="text-danger">{{number_format($data->return_amount, $general->decimal)}} {{$general->currency}} </strong></td>
                        <td>
                            @if($data->status ==-1)
                                <label class="badge bg-danger">{{__('Lose')}}</label>
                            @elseif($data->status ==1)
                                <label class="badge bg-success">{{__('win')}}</label>
                            @elseif($data->status ==0)
                                <label class="badge bg-info">{{__('Pending')}}</label>
                            @elseif($data->status ==2)
                                <label class="badge bg-primary">{{__('Refunded')}}</label>
                            @endif
                        </td>
                        <td>
                            {{date('d M Y h:i A',strtotime($data->created_at))}}
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6"><strong>{{__('No Data Found')}}!!</strong></td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$betInvest->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>
@endsection