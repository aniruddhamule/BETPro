@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($extension as $data)
                    <tr>
                        <td data-label="Extension"><img class="gateway_image_size" src="{{asset('public/images/extension/'.$data->image)}}" alt="img">  {{$data->name}}</td>
                        <td data-label="Status">
                            @if ($data->status == 1)
                            <span class="badge bg-success">{{__('Active')}}</span>
                            @else
                            <span class="badge bg-warning">{{__('Disabled')}}</span>
                            @endif
                        </td>
                        <td data-label="Action">
                            @can('admin-extension-update')
                            <a href="#editExtentionBtn" class="btn btn-dark btn-sm btn-sm editExtenBtn" data-name="{{ __($data->name) }}"
                                title="Edit"
                                data-shortcode="{{ json_encode($data->shortcode) }}"
                                data-action="{{ route('admin.extension.update', $data->id) }}"
                                data-bs-toggle="modal"><i class="las la-edit"></i>
                            </a>
                            @endcan
                            @if($data->status == 0)
                                @can('extension-activate')
                                    <a href="#activateModal"
                                            class="btn btn-success btn-sm btn-sm activateBtn"
                                            data-bs-toggle="modal"
                                            data-id="{{ $data->id }}" 
                                            data-name="{{ __($data->name) }}"
                                            title="{{('Enable')}}">
                                        <i class="las la-eye"></i>
                                    </a>
                                @endcan
                            @else
                                @can('extension-deactivate')
                                    <a href="#deactivateModal"
                                            class="btn btn-danger btn-sm btn-sm deactivateBtn"
                                            data-bs-toggle="modal"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ __($data->name) }}"
                                            title="{{('Disable')}}">
                                        <i class="las la-na"></i>
                                    </a>
                                @endcan
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<div class="modal fade" id="editExtentionBtn" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Update Extension')}}: <span class="extension-name"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['method' => 'POST']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Script')}} <span class="text-danger">*</span></strong></label>
                    {!! Form::textarea('script', null, array('placeholder' => 'Paste your script with proper key','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{__('Update')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

<div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Extension Active Confirmation')}} <span class="extension-name"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['route' => 'extension.activate', 'method' => 'POST']) !!}
            <div class="modal-body">
                <input type="hidden" name="id">
                <p>{{__('Are you sure to activate')}} <span class="extension-name"></span> {{__('extension')}}?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{__('Activate')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Extension Disable Confirmation')}} <span class="extension-name"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['route' => 'extension.deactivate', 'method' => 'POST']) !!}
            <div class="modal-body">
                <input type="hidden" name="id">
                <p>{{__('Are you sure to disable')}} <span class="extension-name"></span> {{__('extension')}}?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">{{__('Disable')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

@endsection

