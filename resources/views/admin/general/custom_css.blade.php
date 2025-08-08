@extends('admin.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{asset('public/backend/css/codemirror.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/css/monokai.min.css')}}">
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <p class="text-primary"><b>{{__('From this page, you can add/update CSS for the user interface. Changing content on this page required programming knowledge.')}}</b></p>
            <p class="text-warning"><b>{{__('Please do not change/edit/add anything without having proper knowledge of it. Any mistake may lead to misbehaving of the system.')}}</b></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{__('Write Custom CSS')}}</h4>
        </div>
        {!! Form::model(array('route' => 'admin.custom.css.update', 'class' => 'forms-sample', 'method' => 'POST')) !!}
        <div class="card-body">
            <div class="form-group">
                <textarea class="form-control" rows="10" name="css" id="customCss">{{ $file_content }}</textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3 me-2">{{__('Submit')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection
@section('script')
    <script src="{{asset('public/backend/js/codemirror.min.js')}}"></script>
    <script src="{{asset('public/backend/js/css.min.js')}}"></script>
    <script src="{{asset('public/backend/js/sublime.min.js')}}"></script>
    <script>
        "use strict";
            var editor = CodeMirror.fromTextArea(document.getElementById("customCss"), {
            lineNumbers: true,
            mode: "text/css",
            theme: "monokai",
            keyMap: "sublime",
            autoCloseBrackets: true,
            matchBrackets: true,
            showCursorWhenSelecting: true,
            matchBrackets: true
        });
    </script>
@endsection

