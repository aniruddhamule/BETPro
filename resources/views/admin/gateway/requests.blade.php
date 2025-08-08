@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Gateway Name')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Charge')}}</th>
                        <th>{{__('TRX')}}</th>
                        <th>{{__('Receipt')}}</th>
                        @if (request()->path() != 'admin/deposit/acceptedRequests' && request()->path() != 'admin/deposit/rejectedRequests')
                        <th>{{__('Action')}}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($deposits as $key => $data)
                    <tr>
                        <td>{{$deposits->firstItem() + $key}}</td>
                        <td><a target="_blank" href="{{route('user.view', $data->user_id)}}">{{$data->user->name}}</a></td>
                        <td>{{$data->gateway->name}}</td>
                        <td>{{round($data->amount, 8)}} {{$general->currency}}</td>
                        <td>{{round($data->charge, 8)}} {{$general->currency}}</td>
                        <td>{{$data->trx}}</td>
                        @can('admin-deposit-showreceipt')
                        <td> <button type="button" class="btn btn-sm btn-primary showImageInModal" data-depID="{{$data->id}}"><i class="ti-eye"></i> {{__('Show')}}</button></td>
                        @endcan
                        @if (request()->path() != 'admin/deposit/acceptedRequests' && request()->path() != 'admin/deposit/rejectedRequests')
                        <td>
                            <div class="row">
                                <div class="col-md-8">
                                    @can('admin-deposit-acceptedrequests')
                                    <form action="{{route('admin.deposit.accept')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="gid" value="{{$data->gateway->id}}">
                                        <input type="hidden" name="dID" value="{{$data->id}}">
                                        <button type="submit" title="Accept" class="btn btn-sm btn-success">
                                            <i class="las la-check"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                                <div class="col-md-4">
                                    @can('admin-deposit-rejectedrequests')
                                    <form action="{{route('admin.deposit.rejectReq')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="dID" value="{{$data->id}}">
                                        <button type="submit" title="Reject" class="btn btn-sm btn-danger">
                                            <i class="las la-times"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$deposits->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade showImageModal" id="showImageModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Receipt Image')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <div class="form-group text-center">
                    <img class="width-100" id="adImage" src="" alt="img">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            </div>
      </div>
    </div>
</div>


@endsection
@section('script')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function(){
                $('.showImageInModal').on('click',function(){
                    $.get(
                        '{{route('admin.deposit.showReceipt')}}',
                        {
                            dID: $(this).attr('data-depID'),
                        },
                        function(data) {
                            $('.showImageModal').modal('show');
                            document.getElementById('adImage').src = '{{asset('public/images/receipt')}}'+'/'+data.r_img;
                        }
                    );
                });
            });
    })(jQuery);
    </script>
@stop

