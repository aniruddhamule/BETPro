@extends('admin.layouts.master')
@section('content')

<div class="row">
    <div class="col-xl-7 col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body p-0">
                <table class="table s7__table">
                    <thead>
                        <tr>
                            <th>{{__('Title')}}</th>
                            <th><b>{{__('Details')}}</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{__('Transaction')}}</td>
                            <td>{{$withdrawLog->withdraw_id}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Member Name')}}</td>
                            <td><a href="{{route('user.view', $withdrawLog->user->id)}}">{{$withdrawLog->user->name}}</a></td>
                        </tr>
                        <tr>
                            <td>{{__('Member Email')}}</td>
                            <td>{{$withdrawLog->user->email}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Amount Of Withdraw')}}</td>
                            <td>{{number_format($withdrawLog->amount,2)}} {{$general->currency}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Charge Of Withdraw')}}</td>
                            <td>{{$withdrawLog->charge}} {{$general->currency}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Withdraw Method')}}</td>
                            <td><b>{{$withdrawLog->method_name}}</b></td>
                        </tr>
                        <tr>
                            <td>{{__('Given Processing Time')}}</td>
                            <td>{{$withdrawLog->processing_time}} Days</td>
                        </tr>
                        <tr>
                            <td>{{__('Amount In Method Currency')}}</td>
                            <td>{{$withdrawLog->method_cur}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Date Of Create')}}</td>
                            <td>{{ date('g:i a \o\n l jS F Y', strtotime($withdrawLog->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>{{__('Details')}}</td>
                            <td>{{$withdrawLog->detail}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Status')}}</td>
                            <td>
                                @if($withdrawLog->status == 0)
                                    <span class="badge bg-warning">{{__('Pending')}}</span>
                                @elseif($withdrawLog->status == 1)
                                    <span class="badge bg-success">{{__('Paid')}}</span>
                                @elseif($withdrawLog->status == 2)
                                    <span class="badge bg-danger">{{__('Refunded')}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="withdraw_td"><p class="text-danger">{{__('Charge Already taken. Send')}} {{floatval($withdrawLog->amount) * floatval($withdrawLog->method_rate) }} {{$withdrawLog->method_cur}} {{__('To The User')}}</p></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    @if($withdrawLog->status == 0)
    <div class="col-xl-5 col-lg-4 col-md-4 grid-margin">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form method="post" action="{{route('admin.withdraw.process', $withdrawLog->id)}}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <label><strong >{{__('Message')}}</strong></label>
                                    <textarea class="form-control" name="message" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="status" value="1" class="btn btn-sm btn-success pull-left">{{__('Processed')}}</button>
                            <button type="submit" name="status" value="2" class="btn btn-sm btn-danger pull-right">{{__('Refund')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

