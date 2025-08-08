@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                @can('admin-close-event')
                <form class="s7__nav-search-form" action="{{route('admin.close.event')}}" method="GET">
                    <input type="text" name="search" placeholder="Search..." autocomplete="off">
                    <button type="submit"><i data-feather="search"></i></button>
                </form>
                @endcan
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Event')}}</th>
                    <th>{{__('Tournament')}}</th>
                    <th>{{__('Total Predict Amount')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Closed Time')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($matches as $key => $data)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td><img src="{{asset('public/images/match/'.$data->team_1_image)}}" alt="img"> {{$data->team_1}} <label class="badge badge-info"> {{__('VS')}} </label> <img src="{{asset('public/images/match/'.$data->team_2_image)}}" alt="img"> {{$data->team_2}}</td>
                        <td>{{($data->event) ? $data->event->name : 'N/A'}}</td>
                        <td><strong>{{$data->totalBetInvests()}} {{$general->currency }}</strong></td>
                        <td>
                            <label class="badge bg-{{ $data->status == 2 ? 'danger' : 'success' }}">{{ $data->status == 2 ? 'Closed' : 'Active' }}</label>
                        </td>
                        <td>
                            {{Carbon\carbon::parse($data->end_date)->format('d M Y H:i A') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$matches->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>
@endsection