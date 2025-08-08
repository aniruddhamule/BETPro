@extends('admin.layouts.master')
@section('content')
<div class="row">
    @include('admin.user.user_sidebar')

    <div class="col-xl-8 col-lg-6 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('Information of')}} {{ ucfirst($user->name) }}</h4>
            </div>
            <form action="{{route('user.detail.update', $user->id)}}" method="post">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><strong>{{__('Name')}}</strong></label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label><strong>{{__('Email')}}</strong></label>
                            <input type="email" class="form-control" name="email" value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><strong>{{__('Gender')}}</strong></label>
                            <select name="gender" class="form-select">
                                <option {{$user->gender == 1? 'selected':''}} value="1">@lang('Male')</option>
                                <option {{$user->gender == 0? 'selected':''}} value="0">@lang('Female')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label><strong>{{__('Phone Number')}}</strong></label>
                            <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('Address')}}</strong></label>
                        <input class="form-control" name="address" value="{{$user->address}}" type="text">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label><strong>{{__('Zip-Code')}}</strong></label>
                            <input class="form-control" name="zip_code" value="{{$user->zip_code}}" type="text">
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>{{__('City')}}</strong></label>
                            <input class="form-control" name="city" value="{{$user->city}}" type="text">
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>{{__('Country')}}</strong></label>
                            <input class="form-control" name="country" value="{{$user->country}}" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label><strong>{{__('Status')}}</strong></label>
                            <select name="status" class="form-select">
                                <option {{$user->status == 1? 'selected':''}} value="1">@lang('Active')</option>
                                <option {{$user->status == 0? 'selected':''}} value="0">@lang('Banned')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label><strong>{{__('Email Verification')}}</strong></label>
                            <select name="emailv" class="form-select">
                                <option {{$user->emailv == 1? 'selected':''}} value="1">@lang('Verified')</option>
                                <option {{$user->emailv == 0? 'selected':''}} value="0">@lang('Unverified')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label><strong>{{__('2FA Status')}}</strong></label>
                            <select name="tauth" class="form-select">
                                <option {{$user->tauth == 1? 'selected':''}} value="1">@lang('Verified')</option>
                                <option {{$user->tauth == 0? 'selected':''}} value="0">@lang('Unverified')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label><strong>{{__('2FA Verification')}}</strong></label>
                            <select name="tfver" class="form-select">
                                <option {{$user->tfver == 1? 'selected':''}} value="1">@lang('Active')</option>
                                <option {{$user->tfver == 0? 'selected':''}} value="0">@lang('Deactive')</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn s7__btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection