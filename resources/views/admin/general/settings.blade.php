@extends('admin.layouts.master')
@section('content')
    <div class="card">
        {!! Form::model($general, array('route' => 'general.store',$general->id, 'class' => 'forms-sample', 'method' => 'POST')) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Site Title')}}</strong></label>
                        {!! Form::text('web_name', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Base Currency')}}</strong></label>
                        {!! Form::text('currency', null, array('placeholder' => 'Currency','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Timezone')}}</strong></label>
                        <select class="form-select" name="timezone">
                            @foreach($timezones as $timezone)
                                <option value="'{{ @$timezone}}'" @if(config('app.timezone') == $timezone) selected @endif>{{ __($timezone) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Currency Symbol')}}</strong></label>
                        {!! Form::text('currency_symbol', null, array('placeholder' => 'Symbol','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label><strong>{{__('Paginate')}}</strong></label>
                        {!! Form::text('paginate', null, array('placeholder' => '0','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <label><strong>{{__('Copy Right Text')}}</strong></label>
                        {!! Form::text('copyright_text', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Base Color')}}</strong></label>
                        <input type="color" class="form-control" name="color_code" value="{{$general->color_code}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Email Verification')}}</strong></label>
                        <select class="form-select" name="emailver">
                            <option value="1" {{$general->emailver == 1?'selected':''}}>{{__('Active')}}</option>
                            <option value="0" {{$general->emailver == 0?'selected':''}}>{{__('Deactive')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><strong>{{__('Email Notification')}}</strong></label>
                        <select class="form-select" name="email_noti">
                            <option value="1" {{$general->email_noti == 1?'selected':''}}>{{__('Active')}}</option>
                            <option value="0" {{$general->email_noti == 0?'selected':''}}>{{__('Deactive')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('Comments')}}</strong></label>
                        {!! Form::textarea('fb_comment', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label><strong>{{__('Footer Text')}}</strong></label>
                        {!! Form::textarea('footer_text', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

