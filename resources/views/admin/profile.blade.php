@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <form action="{{route('admin.updateProfile')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>{{__('Profile Picture')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                            {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview" class="img-fluid" src="{{asset('public/images/admin/'.auth()->guard('admin')->user()->image)}}" alt="your image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>{{__('Name')}} <span class="text-danger">*</span></strong></label>
                            <input type="text" class="form-control" name="name" value="{{auth()->guard('admin')->user()->name}}">
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Email')}} <span class="text-danger">*</span></strong></label>
                            <input type="email" class="form-control" name="email" value="{{auth()->guard('admin')->user()->email}}">
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Current Password')}} <span class="text-danger">*</span></strong></label>
                            <input type="password" name="current_password" class="form-control"  required>
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('New Password')}} <span class="text-danger">*</span></strong></label>
                            <input type="password" name="password" class="form-control" required >
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Confirm Password')}} <span class="text-danger">*</span></strong></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                    </div>  
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Update')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection