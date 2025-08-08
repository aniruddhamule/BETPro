@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Ticket Id')}}</th>
                    <th>{{__('User Name')}}</th>
                    <th>{{__('Subject')}}</th>
                    <th>{{__('Raised Time')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($all_support as $key => $data)
                    <tr>
                        <td>{{$all_support->firstItem() + $key}}</td>
                        <td>{{$data->ticket}}</td>
                        <td>{{$data->user_member->name}}</td>
                        <td>{{$data->subject}}</td>
                        <td>{{$data->created_at->format('F dS, Y')}}</td>
                        <td>
                            @if($data->status == 1)
                                <span class="badge bg-warning"> {{__('Opened')}}</span>
                            @elseif($data->status == 2)
                                <span class="badge bg-success">  {{__('Answered')}} </span>
                            @elseif($data->status == 3)
                                <span class="badge bg-info"> {{__('User Reply')}} </span>
                            @elseif($data->status == 9)
                                <span class="badge bg-danger">  {{__('Closed')}} </span>
                            @endif
                        </td>
                        <td>
                            @can('support-show')
                            <a href="{{route('support.show', $data->ticket)}}" class="btn btn-primary btn-sm">{{__('View')}}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$all_support->links('pagination::bootstrap-4')}} 
            </div>
        </div>
    </div>
@endsection

