@extends('user.layouts.master')
@section('content')
<div class="payment-area support-reply-area bg-navy-2 pd-bottom-220">
    <div class="container-sub">
        <div class="row justify-content-center">
            <div class="col-lg-12 align-self-center">
                <div class="single-payment-wrap">
                    <div class="row mb-4">
                        <div class="col-lg-8 text-start">
                            <h5>#{{$ticket_object->ticket}} - {{$ticket_object->subject}}</h5>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            @if($ticket_object->status == 1)
                            <button class="btn btn-warning btn-sm pull-end mt-2"> {{__('Opened')}}</button>
                            @elseif($ticket_object->status == 2)
                            <button type="button" class="btn btn-success btn-sm pull-end">  {{__('Answered')}} </button>
                            @elseif($ticket_object->status == 3)
                            <button type="button" class="btn btn-info btn-sm pull-end"> {{__('User Reply')}} </button>
                            @elseif($ticket_object->status == 9)
                            <button type="button" class="btn btn-danger btn-sm pull-end">  {{__('Closed')}} </button>
                            @endif
                            <a href="{{route('ticket.close', $ticket_object->ticket)}}" class="btn btn-danger btn-sm pull-end make-close-support mt-2">{{__('Make to Close')}}</a>
                        </div>
                    </div>
                    <div class="single-payment-wrap mb-4 bg-black-5">
                        <div class="row">
                            <div class="col-lg-12">
                                @foreach($ticket_data as $data)
                                <div class="payment-gateway-check form-check">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-start text-white">
                                                @if($data->type == 1)
                                                {{$ticket_object->user_member->name}}
                                                @else
                                                {{$ticket_object->admin->name}}
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="col-md-6 text-sm-end text-start">
                                            <small>{{$data->updated_at->format('d M, Y - h:i A') }}</small>
                                        </div>
                                    </div>
                                    <p class="text-start ">{!! $data->comment !!}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="contact-inner">
                            <form method="POST" action="{{route('store.user.reply', $ticket_object->ticket)}}" accept-charset="UTF-8" class="form-horizontal form-bordered">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="single-input-inner style-border">
                                        <span class="input-group-text">{{__('Reply')}}:</span>
                                        <textarea class="border-0 bg-black-5" name="comment" cols="30" rows="10"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-base mt-3">{{__('Post')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection