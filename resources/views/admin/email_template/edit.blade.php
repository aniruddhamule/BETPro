@extends('admin.layouts.master')
@section('content')
<div class="card mb-4">
    <div class="card-body p-0">
        <table class="table s7__table">
            <thead>
                <tr>
                    <th>{{__('CODE')}} </th>
                    <th>{{__('DESCRIPTION')}} </th>
                </tr>
            </thead>
            <tbody>
            @if($email_template->shortcodes)
                @foreach($email_template->shortcodes as $data => $key)
                <tr>
                    <th><pre>@php echo "{{". $data ."}}"  @endphp</pre></th>
                    <td>{{ __($key) }} </td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
    
    <div class="card">
        <form class="forms-sample" action="{{ route('email-template.update', $email_template->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-8">
                        <label><strong>{{__('Subject')}}</strong></label>
                        <input type="text" class="form-control" placeholder="{{__('Email subject')}}" name="subj" value="{{ $email_template->subj }}"/>
                    </div>
                    <div class="form-group col-md-4">
                        <strong>{{__('Status')}} <span class="text-danger">*</span></strong>
                        <input type="checkbox" data-onstyle="-success"
                                data-offstyle="-danger" data-toggle="toggle" data-on="{{__('Send Email')}}"
                                data-off="{{__("Don't Send")}}" name="email_status"
                                @if($email_template->email_status) checked @endif>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>{{__('Message')}}</strong></label>
                    <textarea name="email_body" rows="10" class="form-control" placeholder="{{__('Your message using shortcodes')}}">{{ $email_template->email_body }}</textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Update')}}</button>
                </div>
            </div>
        </form>
    </div>

@endsection