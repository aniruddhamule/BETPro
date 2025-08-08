@extends('admin.layouts.master')
@section('content')
    <div class="card">
        {!! Form::model($section_btn, array('route' => ['section-manage.update', $section_btn->id], 'class' => 'forms-sample', 'method' => 'POST')) !!}
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label><strong>{{__('Contact Page Switch')}}</strong></label>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-switch">
                        <input class="form-check-input" type="checkbox" name="contact_switch" value="1" @if ($section_btn->contact_switch == 1) checked @endif>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label><strong>{{__('About Area Switch')}}</strong></label>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-switch">
                        <input class="form-check-input" type="checkbox" name="about_switch" value="1" @if ($section_btn->about_switch == 1) checked @endif>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label><strong>{{__('Predict Area Switch')}}</strong></label>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-switch">
                        <input class="form-check-input" type="checkbox" name="event_switch" value="1" @if ($section_btn->event_switch == 1) checked @endif>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label><strong>{{__('Service Area Switch')}}</strong></label>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-switch">
                        <input class="form-check-input" type="checkbox" name="service_switch" value="1" @if ($section_btn->service_switch == 1) checked @endif>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label><strong>{{__('Leader Board Area Switch')}}</strong></label>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-switch">
                        <input class="form-check-input" type="checkbox" name="leaderboard_switch" value="1" @if ($section_btn->leaderboard_switch == 1) checked @endif>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label><strong>{{__('Testimonial Area Switch')}}</strong></label>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-switch">
                        <input class="form-check-input" type="checkbox" name="testimonial_switch" value="1" @if ($section_btn->testimonial_switch == 1) checked @endif>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label><strong>{{__('News Area Switch')}}</strong></label>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-switch">
                        <input class="form-check-input" type="checkbox" name="news_switch" value="1" @if ($section_btn->news_switch == 1) checked @endif>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary me-2">{{__('Submit')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection