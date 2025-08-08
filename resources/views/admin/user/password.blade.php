@extends('admin.layouts.master')
@section('content')
<div class="row">
    @include('admin.user.user_sidebar')
    <div class="col-xl-8 col-lg-6 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ ucfirst($user->name) }} {{__('Password Settings')}}</h4>
            </div>
            <form action="{{route('user.pass-update',[$user->id])}}" method="post">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group">
                        <label><strong>{{__('New Password')}}</strong></label>
                        <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('Confirm Password')}}</strong></label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn s7__btn-primary">{{__('Update Password')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection