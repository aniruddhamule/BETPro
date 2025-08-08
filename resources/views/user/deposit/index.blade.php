@extends('user.layouts.master')
@section('content')
<div id="app" class="contact-area bg-navy-2 pd-bottom-220">
    <div class="container-sub bg-black-2 rounded-3 p-4">
        <div class="rows d-flex justify-content-center" v-if="step === 1">
            <div class="col-md-7 mt-5 mb-5">
                <form  @submit="submitAmount">
                    <div class="contact-inner">
                        <h2 class="title mb-4 text-center">{{__('Add Payment Here')}}</h2>
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Enter Amount')}}</span>
                            <span class="icon"><i class="fa fa-dollar-sign"></i></span>
                            <input name="amount" v-model="deposit.payment_amount" placeholder="{{__('Amount')}}" type="text" autocomplete="off" min="0" required>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-base mt-3" type="submit">{{__('SUBMIT NOW')}} <i class="fas fa-arrow-circle-right ms-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" v-if="step === 2">
            <div class="col-md-12 mb-2">
                <button class="btn btn-base" @click="backStepOne"><i class="fas fa-arrow-circle-left ms-2"></i> {{__('Back')}}</button>
            </div>
            @foreach ($gateways as $data)
            <div class="col-lg-3 align-self-center">
                <div class="single-payment-wrap">
                    <div class="thumb">
                        <img src="{{$data->image_url}}" alt="{{$data->name}}">
                    </div>
                    <div class="details">
                        <h4>{{__($data->name)}}</h4>
                        <button class="btn btn-base" type="button" @click="selectGateway('{{$data}}')">{{__('Deposit Now')}}</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row d-flex justify-content-center bg-black-2 rounded-3 mb-4" v-if="step === 3">
            <div class="col-md-6 mt-5 mb-2">
                <div class="text-center">
                    <img :src="gatewayItem.image_url" class="rounded" alt="{{__('Gateway Image')}}">
                  </div>
            </div>
            <div class="col-md-6 mt-5 mb-5">
               <form ref="formPayment" action="{{route('deposit.confirm')}}" method="POST" enctype="multipart/form-data" >
                @csrf

                <input type="hidden" name="gateway_id" v-bind:value="gatewayItem.id">
                <input type="hidden" name="amount" v-bind:value="deposit.payment_amount">

                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active" aria-current="true"> <h4>{{__('Confirm Payment')}}</h4></li>
                            <li class="list-group-item">{{__('Fixed Charge')}} : @{{gatewayItem.fixed_charge}} USD</li>
                            <li class="list-group-item">{{__('Percentage Charge')}} : @{{gatewayItem.percentage_charge}}%</li>
                            <li class="list-group-item">{{__('Payment Amount')}} : @{{deposit.payment_amount}} USD</li>
                            <li class="list-group-item"></li>
                            <li class="list-group-item text-danger fw-bold">{{__('Total Charge')}} : @{{ (( parseFloat(deposit.payment_amount) * parseFloat(gatewayItem.percentage_charge) )/100)+(parseFloat(gatewayItem.fixed_charge))}} USD</li>
                            <li class="list-group-item text-success fw-bold">{{__('Total Payable')}} : @{{parseFloat(deposit.payment_amount)+(parseFloat(gatewayItem.fixed_charge)) + (( parseFloat(deposit.payment_amount) * parseFloat(gatewayItem.percentage_charge) )/100)}} USD</li>
                            <li v-if="gatewayItem.id > 99" class="list-group-item"></li>
                            <li v-if="gatewayItem.id > 99" class="list-group-item">{{__('Payment Description')}} : @{{gatewayItem.gateway_key_four}} <br></li>
                        </ul>
                    </div>
                    <div class="col-md-12" v-if="gatewayItem.id > 99">
                        <div class="mb-3">
                            <label for="ReceiptImage" class="form-label">{{__('Payment Receipt')}}</label>
                            <input type="file" class="form-control" name="receipt_image" id="ReceiptImage" aria-describedby="ReceiptImageHelp">
                            <div id="ReceiptImageHelp" class="form-text">{{__('Please upload your complete payment Receipt here')}}</div>
                          </div>
                          <div class="mb-3">
                            <label for="DetailsPayment" class="form-label">{{__('Details')}}</label>
                            <textarea class="form-control" id="DetailsPayment" rows="3" name="payment_des" placeholder="{{__('Payment Details (not required)')}}"></textarea>
                          </div>
                    </div>
                    <div class="col-md-12 mt-5 text-center">
                        <button class="btn btn-base mb-2" type="submit" @click="payNow">{{__('Confirm Pay')}} <i class="fas fa-arrow-circle-right ms-2"></i></button>
                        <button class="btn btn-base mb-2" type="button" @click="backStepTwo"><i class="fas fa-arrow-circle-left ms-2"></i> {{__('Back')}}</button>
                    </div>
                </div>
               </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
     window.app = new Vue({
            el: '#app',
            data: {
                deposit: {},
                gatewayItem : {},
                step:1,
            },
            methods: {
                backStepOne(){
                    this.step--;
                },
                backStepTwo(){
                    this.step--;
                },
                toastMsg(message, type = null){
                    if(type == 'error'){
                        var heading = "{{__('Opps')}}";
                        var status = TOAST_STATUS.DANGER;
                    }else{
                        var heading = "{{__('Success')}}";
                        var status = TOAST_STATUS.SUCCESS;
                    }
                    let toast = {
                        title: heading,
                        message: message,
                        status: heading,
                        timeout: 6000
                    }
                    Toast.create(toast);
                },
                submitAmount(e) {
                    e.preventDefault();
                    if(this.deposit.payment_amount > 0){
                        this.step++
                    }else{
                        this.toastMsg("{{__('Please insert a valid amount.')}}", "error");
                    }
                },
                selectGateway(item){
                    var item = JSON.parse(item);
                    if((parseFloat(this.deposit.payment_amount) >= parseFloat(item.minimum_deposit_amount)) && (parseFloat(this.deposit.payment_amount) <= parseFloat(item.maximum_deposit_amount))){
                        this.step++;
                        this.gatewayItem = item;
                    }else{
                        var msg = 'Please go back & insert beetween Min '+item.minimum_deposit_amount+'- Max '+item.maximum_deposit_amount+' for '+item.name;
                        this.toastMsg(msg, "error");
                    }
                },
                payNow(){
                   this.$refs.formPayment.$el.submit()
                }
            }
        })
</script>
@endsection
