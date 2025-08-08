@extends('admin.layouts.master')
@section('content')
<div class="row">
    @include('admin.user.user_sidebar')
    <div class="col-xl-8 col-lg-6 col-md-6 grid-margin stretch-card">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4 class="card-title">{{ ucfirst($user->name) }} {{__('Manage Balance')}}</h4>
                    </div>
                    <form action="{{route('send.mail.user')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <label><strong>{{__('Send To')}}</strong></label>
                                    <input type="email" name="emailto" class="form-control" value="{{$user->email}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('Name')}}</strong></label>
                                    <input type="text" name="receiver" class="form-control" value="{{$user->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('Subject')}}</strong></label>
                                    <input class="form-control" name="subject" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('Message')}}</strong></label>
                                    <textarea name="message" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">{{__('Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection