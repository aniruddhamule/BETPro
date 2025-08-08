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
                <tr>
                    <td><pre>@php echo "{{name}}"  @endphp</pre></td>
                    <td>{{__("Users Name. Will Pull From Database and Use in EMAIL text.")}} </td>
                </tr>
                <tr>
                    <td><pre>@php echo "{{message}}"  @endphp</pre></td>
                    <td>{{__("Details Text From Script.")}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        {!! Form::model($general, array('route' => 'general.store',$general->id, 'class' => 'forms-sample', 'method' => 'POST')) !!}
        <div class="card-body">
            <div class="row">
                <div class="form-group">
                    <label><strong>{{__('Sent Email From')}}</strong></label>
                    {!! Form::text('global_email', null, array('placeholder' => 'Email Address','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Email Message')}}</strong></label>
                    {!! Form::textarea('global_description', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection