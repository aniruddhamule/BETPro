@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            @can('admin-referral-update')
            <h4 class="card-title text-end"><button id="addLevel" type="button" class="btn s7__btn-primary btn-sm">
                <i class="las la-plus"></i>
            {{__('Add New Level')}}
            </button></h4>
            @endcan
        </div>
        <div class="card-body">
            <form action="{{route('admin.referral.update')}}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <p class="text-danger font-weight-bold">{{__('NOTE : Insert "Blank or remove percentage value" for delete Level Commission.')}}</p>
                    </div>
                    <div class="col-md-8">
                        @foreach($ref as $data)
                            <div class="form-group">
                                <label><strong>{{$data->id}} {{__('Level Commission')}}</strong></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="percentage[]" placeholder="Commission Percentage" value="{{$data->percentage}}" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group" id="newLevel">
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary me-2">{{__('Update')}}</button>
                        </div>
                    </div>  
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function($) {
            "use strict";
            @if(($lastRef instanceof \App\Models\Referral))
             var count = parseInt('{{$lastRef->id}}');
            @else
            var count = 0;
            @endif
            $("#addLevel").on('click',function() {
                count += 1;
                $("#newLevel").append(
                    `<label><strong>`+count+` Level Commission</strong></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="percentage[]" placeholder="Commission Percentage" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>`
                );
            });
        })(jQuery);
    </script>
@endsection