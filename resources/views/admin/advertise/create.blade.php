@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="banner-tab" data-bs-toggle="tab" href="#banner" role="tab" aria-controls="banner" aria-selected="true">{{__('Banner/Image Advertise')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="script-tab" data-bs-toggle="tab" href="#script" role="tab" aria-controls="script" aria-selected="false">{{__('Script Advertise')}}</a>
                </li>
            </ul>
            {!! Form::open(array('route' => 'advertise.store', 'class' => 'forms-sample', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="banner" role="tabpanel" aria-labelledby="banner-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>{{__('Banner Image')}}</strong></label>
                                <input type="file" id="file-input" class="form-control" name="image">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div id='img_contain'>
                                            <img id="image-preview" class="img-fluid" src="{{asset('public/images/no-image.png')}}" alt="your image"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><strong>{{__('Banner Size')}}</strong></label>
                                <select class="form-select" name="image_size">
                                    <option selected disabled value="">{{__('Choose')}}...</option>
                                        <option value="leaderboard">{{__('728×90 Leaderboard Banner')}}</option>
                                        <option value="large-Leaderboard">{{__('970×90	Large Leaderboard')}}</option>
                                        <option value="square">{{__('250×250 Square')}}</option>
                                        <option value="small-square">{{__('200×200	Small Square')}}</option>
                                        <option value="medium-rectangle">{{__('300×250	Medium Rectangle')}}</option>
                                        <option value="rectangle">{{__('160×600 Rectangle')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><strong>{{__('Redirect Url')}}</strong></label>
                                {!! Form::text('image_redirect_url', null, array('placeholder' => 'Redirect Url','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3 me-2" name="type" value="1">{{__('Submit')}}</button> 
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="script" role="tabpanel" aria-labelledby="script-tab">
                    <div class="form-group">
                        <label><strong>{{__('Add Advertise Script')}}</strong></label>
                        {!! Form::textarea('script', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 me-2" name="type" value="2">{{__('Submit')}}</button> 
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection