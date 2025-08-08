@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title text-end"><a href="{{ route('admin.notifications.readAll') }}" class="btn-sm btn btn-primary">@lang('Mark all as read')</a></h4>
    </div>
    <div class="card-body">
        <h6 class="mb-3">Users Activity</h6>
        <div class="timeline-wrapper">
            @foreach($notifications as $data)
            <a class="notify_item @if($data->read_status == 0) unread-notification @endif" href="{{ route('admin.notification.read',$data->id) }}">
                <div class="timeline-item">
                    <div class="timeline-circle s7__border-1"></div>
                    <div class="timeline-content">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <h6 class="mb-0">{{$data->user->name}}</h6>
                            <span class="s7__text-muted text-small">{{ $data->created_at->diffForHumans() }}</span>
                        </div>
                        <p>{{ __($data->title) }}</p>
                        <img src="{{asset('public/images/user/'.$data->user->image)}}" alt="image" class="avatar-75px rounded-3">
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
            {{$notifications->links('pagination::bootstrap-4')}} 
        </div>
    </div>
</div>

@endsection
