@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::model($gateway, ['method' => 'PATCH','route' => ['gateway.update', $gateway->id], 'class' => 'forms-sample', 'enctype' => 'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-md-5">
                        <input class="form-control" value="{{$gateway->id}}" type="hidden" name="id">
                        <div class="form-group">
                            <label><strong>{{__('Image')}} <small>{{__('(PNG format is standard)')}}</small></strong></label>
                            {!! Form::file('image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview" class="img-fluid" src="{{asset('public/images/gateway/'.$gateway->image)}}" alt="your image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{__('Name of Gateway')}}</strong></label>
                                    {!! Form::text('name', null, array('id' => 'name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{__('Rate')}}</strong></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">1 USD =</span>
                                        {!! Form::text('rate', null, array('class' => 'form-control')) !!}
                                        <span class="input-group-text">{{$general->currency}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card--custom mb-3">
                                    <div class="card-header bg-primary text-white"><strong>{{__('Deposit Limit')}}</strong></div>
                                    <div class="card-body">
                                        <label><strong>{{__('Minimum Amount')}}</strong></label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('minimum_deposit_amount', null, array('class' => 'form-control')) !!}
                                            <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                        </div>
                                        <label><strong>{{__('Maximum Amount')}}</strong></label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('maximum_deposit_amount', null, array('class' => 'form-control')) !!}
                                            <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card--custom mb-3">
                                    <div class="card-header bg-primary text-white"><strong>{{__('Deposit Charge')}}</strong></div>
                                    <div class="card-body">
                                        <label><strong>{{__('Fixed Charge')}}</strong></label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('fixed_charge', null, array('class' => 'form-control')) !!}
                                            <span class="input-group-text" id="basic-addon2">{{$general->currency}}</span>
                                        </div>
                                        <label><strong>{{__('Charge in Percentage')}}</strong></label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('percentage_charge', null, array('class' => 'form-control')) !!}
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{__('Status')}}</strong></label>
                                    <select class="form-select" name="status">
                                        <option value="1" {{$gateway->status==1?'selected':''}}>{{__('Active')}}</option>
                                        <option value="0" {{$gateway->status==0?'selected':''}}>{{__('Inactive')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($gateway->id > 99)
                    <div class="form-group">
                        <label><strong>{{__('PAYMENT DETAILS')}}</strong></label>
                        {!! Form::textarea('gateway_key_four', null, array('class' => 'form-control')) !!}
                    </div>
                @endif

                @if($gateway->id==1)
                    <div class="form-group">
                        <label><strong>{{__('PAYPAL API LIVE CLIENT ID')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('PAYPAL API LIVE CLIENT SECRET')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('PAYPAL API APP ID')}}</strong></label>
                        {!! Form::text('gateway_key_three', null, array('id' => 'gateway_key_three', 'class' => 'form-control')) !!}
                    </div>
                @endif

                @if($gateway->id==2)
                    <div class="form-group">
                        <label><strong>{{__('COINPAYMENT MERCHANT ID')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('COINPAYMENT SECRET')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                @endif

                @if($gateway->id==3)
                    <div class="form-group">
                        <label><strong>{{__('STRIPE SECRET')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('STRIPE KEY')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                @endif

                @if($gateway->id==4)
                    <div class="form-group">
                        <label><strong>{{__('PAYFAST MERCHANT ID')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('PAYFAST MERCHANT KEY')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                @endif


                @if($gateway->id==5)
                    <div class="form-group">
                        <label><strong>{{__('Callback URL')}}</strong></label>
                        <input type="text" value="{{url('/')}}/paystack-payment/callback" class="form-control" readonly>
                        <p class="text-success"><small>{{__('Copy this link & save on your paystack portal (API Keys & Webhooks)')}}</small></p>
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('PAYSTACK PUBLIC KEY')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('PAYSTACK SECRET KEY')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('MERCHANT EMAIL')}}</strong></label>
                        {!! Form::text('gateway_key_three', null, array('id' => 'gateway_key_three', 'class' => 'form-control')) !!}
                    </div>
                @endif

                @if($gateway->id==6)
                <div class="form-group">
                    <label><strong>{{__('FLW PUBLIC KEY')}}</strong></label>
                    {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                    <label><strong>{{__('FLW SECRET KEY')}}</strong></label>
                    {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                    <label><strong>{{__('FLW SECRET HASH')}}</strong></label>
                    {!! Form::text('gateway_key_three', null, array('id' => 'gateway_key_three', 'class' => 'form-control')) !!}
                </div>
                @endif


                @if($gateway->id==7)
                <div class="form-group">
                    <label><strong>{{__('PAYTM MERCHANT ID')}}</strong></label>
                    {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                    <label><strong>{{__('PAYTM MERCHANT KEY')}}</strong></label>
                    {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                </div>
                @endif

                @if($gateway->id==8)
                <div class="form-group">
                    <label><strong>{{__('Skrill EMAIL')}}</strong></label>
                    {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                </div>
                @endif
                @if($gateway->id==9)
                    <div class="form-group">
                        <label><strong>{{__('MERCHANT LOGIN ID')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <label><strong>{{__('MERCHANT TRANSACTION KEY')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                @endif
                @if($gateway->id==10)
                    <div class="form-group">
                        <label><strong>{{__('API KEY')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>
                @endif
                @if($gateway->id==11)
                    <div class="form-group">
                        <label><strong>{{__('API KEY')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('AUTH TOKEN')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('API URL')}}</strong></label>
                        {!! Form::url('gateway_key_three', null, array('id' => 'gateway_key_three', 'class' => 'form-control')) !!}
                    </div>
                @endif
                @if($gateway->id==12)
                    <div class="form-group">
                        <label><strong>{{__('PUBLIC KEY')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('SECRET KEY')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                @endif
                @if($gateway->id==13)
                    <div class="form-group">
                        <label><strong>{{__('API KEY')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>
                @endif
                @if($gateway->id==14)
                    <div class="form-group">
                        <label><strong>{{__('API KEY')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('SECRET KEY')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                @endif
                @if($gateway->id==15)
                    <div class="form-group">
                        <label><strong>{{__('PUBLISHABLE KEY')}}</strong></label>
                        {!! Form::text('gateway_key_one', null, array('id' => 'gateway_key_one', 'class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label><strong>{{__('PRIVATE KEY')}}</strong></label>
                        {!! Form::text('gateway_key_two', null, array('id' => 'gateway_key_two', 'class' => 'form-control')) !!}
                    </div>
                @endif
                
                <div class="text-center mt-3">
                    <button type="submit" class="btn s7__btn-primary me-2">{{__('Update')}}</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

@endsection

