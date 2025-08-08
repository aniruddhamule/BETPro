@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-8">
                    <h4 class="card-title mb-0">#{{$ticket_object->ticket}} - {{$ticket_object->subject}}</h4>
                </div>
                <div class="col-4 text-end">
                    @if($ticket_object->status == 1)
                        <button class="btn btn-warning"> {{__('Opened')}}</button>
                    @elseif($ticket_object->status == 2)
                        <button type="button" class="btn btn-success">  {{__('Answered')}} </button>
                    @elseif($ticket_object->status == 3)
                        <button type="button" class="btn btn-info"> {{__('Customer Reply')}} </button>
                    @elseif($ticket_object->status == 9)
                        <button type="button" class="btn btn-danger">  {{__('Closed')}} </button>
                    @endif
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('store.admin.reply', $ticket_object->ticket)}}" accept-charset="UTF-8" class="form-horizontal form-bordered">
                {{csrf_field()}}
                <div class="mb-3">
                    <div class="col-md-12">
                        @foreach($ticket_data as $data)
                        <div class="card mb-4 @if($data->type == 1) aquamarine @else support_color @endif">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col ml--2">
                                        <div class="row">
                                            <div  class="col-md-6">
                                                <h4 class="support_text">
                                                    @if($data->type == 1)
                                                        {{$ticket_object->user_member->name}}
                                                    @else
                                                        {{Auth::guard('admin')->user()->name}}
                                                    @endif 
                                                </h4>
                                            </div>
                                            <div class="col-md-6 text-end suprt_fnt_clr">
                                                <small>{{$data->updated_at->format('F dS, Y - h:i A') }}</small>
                                            </div>
                                        </div>
                                        <br>
                                        <p class="text-sm mb-0 suprt_fnt_clr">{!! $data->comment !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label><strong>{{__('Reply')}}: </strong></label>
                    <textarea class="form-control" name="comment" rows="10"></textarea>
                </div>
                <button type="submit" class="btn btn-primary col-md-12"><i class="fa fa-check"></i> {{__('Post')}}</button>
            </form>
        </div>
    </div>
@endsection

