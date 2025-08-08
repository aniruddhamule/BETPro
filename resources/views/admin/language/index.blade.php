@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-end align-items-center">
                @can('language-create')
                    <h4 class="card-title text-end">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#langAddModel" class="btn btn-primary btn-sm">
                            <i class="las la-plus"></i>
                        {{__('Add New')}}
                    </button>
                @endcan
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Code')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($lang as $key => $data)
                    <tr>
                        <td>{{$lang->firstItem() + $key}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->code}}</td>
                        <td>
                            @can('language-key-update')
                            <a href="{{route('language.edit', $data->id)}}" class="btn btn-primary btn-sm"><i class="ti-split-v-alt"></i> {{__('Keyword Edit')}}</a>
                            @endcan
                            @can('language-edit')
                            <a href="#editLangModal" data-route="{{route('language.update',$data->id)}}" data-bs-toggle="modal" data-name="{{$data->name}}" 
                                title="Edit" class="btn btn-dark btn-sm editLangBtn"><i class="las la-edit"></i></a>
                            @endcan
                            @can('language-destroy')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['language.destroy', $data->id], 'style' => 'display:inline']) !!}
                            {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete','class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$lang->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade" id="langAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Add New Language')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'language.store', 'method' => 'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Language Name')}}</strong></label>
                    {!! Form::text('name', null, array('placeholder' => 'Language Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Language Code')}}</strong></label>
                    {!! Form::text('code', null, array('placeholder' => 'Language Code','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

<div class="modal fade" id="editLangModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Edit Language')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['id' => 'editLang', 'method' => 'PATCH']) !!}
            @csrf
            @method('put')
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Language Name')}}<strong></label>
                    {!! Form::text('name', null, array('id' => 'editLangName', 'placeholder' => 'Language Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

@endsection

