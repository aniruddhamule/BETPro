@extends('admin.layouts.master')
@section('content')
<div id="app" v-cloak>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="tile-title"> {{ $page_title }} (<small>{{__('Click Add Translatable Add Put Your Key For Translate')}}</small>)</h3>
                    <small class="text-danger">{{__('"Add Translatable Key" please careful when you entering word or sentences, there shouldn\'t be any extra space or break.')}}</small>
                    <small class="text-success">{{__('If your keywords are perfect but translator doesn\'t work, don\'t worry. escape all dynamic keywords and add single word, it\'ll work.')}}</small>
                </div>
                <div class="col-md-4">
                    @can('import_lang')
                    <form class="forms-sample" method="post" @submit.prevent="importKey">
                        <div class="form-group mb-2">
                            <select class="form-select" required v-model="importData.code">
                                <option value="">{{__('Import Keywords (Select Language)')}}</option>
                                @foreach($language as $data)
                                    @if($data->id != $la->id)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">{{__('Import Now')}}</button>
                    </form>
                    @endcan
                    <small class="text-danger">{{__('If you import keywords from another language, Your present')}} "{{$la->name}}" {{__('all keywords will remove.')}}</small>
                </div>
            </div>
            <hr>
            <div class="tile-body">
                {!! Form::model($la, ['method' => 'PUT','route' => ['language-key-update', $la->id], 'class' => 'forms-sample', 'id' => 'langForm']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3" v-for="(value, key) in datas" :key="key">
                                <label class="form-label">@{{ key }}</label>
                                <div class="input-group">
                                    <input type="text" :value="value" :name="'keys[' + key + ']'" class="form-control">
                                    <span class="input-group-text bg-danger text-white" @click.prevent="deleteElement(key)"><i class="las la-trash"></i></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#keyAddModal" class="btn btn-primary">{{__('Add Translatable Key')}}</button>
                                <button class="btn btn-success" data-toggle="tooltip" title="{{__('Save')}}" @click.prevent="save">{{__('Save')}}</button>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-block"><i class="fa fa-send"></i> {{__('Update')}}</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="modal fade" id="keyAddModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">{{__('Translate Language')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {!! Form::open(array('id' => 'newlangForm')) !!}
                        <div class="modal-body">
                            <div class="form-group">
                                <label><strong>{{__('English')}}</strong></label>
                                <input type="text" class="form-control" v-model="newKey" required>
                            </div>
                            <div class="form-group">
                                <label><strong>{{$la->name}}</strong></label>
                                <input type="text" class="form-control" v-model="newVal" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                            <input type="submit" class="btn btn-success" value="Add Field" @click.prevent="addfield()">
                        </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('script')
    <script type="text/javascript" data-datas="{{$json}}" data-current="{{ $la->code }}" data-route="{{route('import_lang')}}" src="{{asset('public/backend/js/extra/lang.js')}}"></script>
@endsection

