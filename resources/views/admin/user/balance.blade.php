@extends('admin.layouts.master')
@section('content')
<div class="row">
    @include('admin.user.user_sidebar')
    <div class="col-xl-8 col-lg-6 col-md-6 grid-margin stretch-card">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form action="{{route('user.balance.update',[$user->id])}}" method="post">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">{{ ucfirst($user->name) }} {{__('Manage Balance')}}</h4>
                            <hr>
                            <div class="row">
                                <div class="form-group">
                                    <label><strong>{{__('Operation')}}</strong></label>
                                    <select name="operation" class="form-select">
                                        <option value="1">{{__('Add Balance')}}</option>
                                        <option value="0">{{__('Deduct Money')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('Amount')}}</strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="amount" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>{{__('Message')}}</strong></label>
                                    <textarea name="message" rows="5" class="form-control"  placeholder="{{__('if any')}}"></textarea>
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