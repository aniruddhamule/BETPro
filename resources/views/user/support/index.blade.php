@extends('user.layouts.master')
@section('content')
<div class="leaderboard-area pd-bottom-150 bg-navy-2">
    <div class="container-sub">
        <div class="row justify-content-end">
            <div class="col-lg-8 align-self-end">
                <div class="section-title style-white text-lg-end mb-4">
                    <a href="{{route('user.new.ticket') }}" class="btn btn-base mt-0">
                        <i class="fa fa-plus"></i>  {{__('New Ticket')}}
                    </a>
                </div>  
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="leaderboard-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('SL')}}</th>
                                <th>{{__('Subject')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Last Reply')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $key => $data)
                            <tr>
                                <td class="number">{{$key+1}}</td>
                                <td class="prediction-wrap"><a href="{{ route('ticket.user.reply', $data->ticket) }}" class="font-weight-bold"> [{{__('Ticket')}}#{{ $data->ticket }}] {{ __($data->subject) }} </a></td>
                                <td class="prediction-amount">
                                    @if($data->status == 0)
                                        <span class="badge bg-success">{{__('Open')}}</span>
                                    @elseif($data->status == 1)
                                        <span class="badge bg-primary">{{__('Answered')}}</span>
                                    @elseif($data->status == 2)
                                        <span class="badge bg-warning">{{__('Customer Reply')}}</span>
                                    @elseif($data->status == 3)
                                        <span class="badge bg-dark">{{__('Closed')}}</span>
                                    @endif
                                </td>
                                <td class="prediction-time">{{ \Carbon\Carbon::parse($data->last_reply)->diffForHumans() }}</td>
                                <td class="prediction-amount"><a href="{{ route('ticket.user.reply', $data->ticket) }}" type="button" class="btn btn-base btn-sm">
                                    {{__('View')}}
                                </a></td>
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
                    {{$supports->links('pagination::bootstrap-4')}} 
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection