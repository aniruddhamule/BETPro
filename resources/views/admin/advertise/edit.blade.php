@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::model($advertise, ['method' => 'PATCH','route' => ['advertise.update', $advertise->id], 'class' => 'forms-sample', 'enctype' => 'multipart/form-data']) !!}
            @if($session == 'banner')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>{{__('Banner Image')}}</strong></label>
                            {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview" class="img-fluid" src="{{asset('public/images/advertise/'.$advertise->image)}}" alt="your image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>{{__('Banner Size')}}</strong></label>
                            <select class="form-select" id="validationCustom04" name="image_size">
                                <option selected disabled value="">{{__('Choose')}}...</option>
                                <option {{$advertise->image_type == 'leaderboard'? 'selected':''}} value="leaderboard">{{__('728×90 Leaderboard Banner')}}</option>
                                <option {{$advertise->image_type == 'large-Leaderboard'? 'selected':''}} value="large-Leaderboard">{{__('970×90	Large Leaderboard')}}</option>
                                <option {{$advertise->image_type == 'square'? 'selected':''}} value="square">{{__('250×250 Square')}}</option>
                                <option {{$advertise->image_type == 'small-square'? 'selected':''}} value="small-square">{{__('200×200	Small Square')}}</option>
                                <option {{$advertise->image_type == 'medium-rectangle'? 'selected':''}} value="medium-rectangle">{{__('300×250	Medium Rectangle')}}</option>
                                <option value="rectangle">{{__('160×600 Rectangle')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>{{__('Redirect Url')}}</strong></label>
                            {!! Form::text('image_redirect_url', null, array('placeholder' => 'Redirect Url','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2" name="type" value="1">@lang('Update')</button>
                    </div>
                </div>
            @elseif($session == 'script')
                <div class="row">
                    <div class="form-group">
                        <label><strong>{{__('Add Advertise Script')}}</strong></label>
                        {!! Form::textarea('script', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2" name="type" value="2">@lang('Update')</button>
                    </div>
                </div>
            @endif
            {!! Form::close() !!}
        </div>
    </div>
@endsection

