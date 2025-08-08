@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
                <h4 class="card-title text-end"><a href="{{route('admin.all.matches')}}" class="btn btn-sm s7__btn-dark @if(Request::routeIs('admin.all.matches')) active @endif">
                    <i class="las la-arrow-left"></i> {{__('Go Back')}}
                    </a>
                    @can('admin-save-question')
                    <button type="button" data-bs-toggle="modal" data-bs-target="#questionsAddModel" class="btn s7__btn-primary btn-sm">
                    <i class="las la-plus"></i> {{__('Add New')}}</button>
                    @endcan
                </h4>
        </div>
            <div class="card-body p-0">
                <table class="table s7__table">
                    <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Question')}}</th>
                        <th>{{__('Option Count')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $key => $data)
                        <tr>
                            <td>{{$questions->firstItem() + $key}}</td>
                            <td>{{$data->question}}</td>
                            <td>{{__($data->options->count())}}</td>
                            <td>
                                @if ($data->status == 1)
                                <span class="badge bg-success">{{__('Active')}}</span>
                                @else
                                <span class="badge bg-warning">{{__('Disabled')}}</span>
                                @endif
                            </td>
                            <td>
                                @can('admin-update-question')
                                <button type="button" class="btn s7__btn-secondary btn-sm edit_qus_button" 
                                title="Edit Question"
                                data-bs-toggle="modal" data-bs-target="#editQuestionsModal"
                                data-act="Edit"
                                data-name="{{$data->question}}"
                                data-datetime="{{date('H:i',strtotime($data->end_time))}}"
                                data-enddate="{{date('m/d/Y',strtotime($data->end_time))}}"
                                data-status="{{$data->status}}"
                                data-id="{{$data->id}}"
                                data-mid="{{$data->match_id}}"><i class="las la-edit"></i></button>
                                @endcan
                                @php
                                    $totalOptions = $data->options()->count();
                                @endphp
                                @can('admin-view-option')
                                <a href="{{route('admin.view.option', $data->id )}}"class="btn s7__btn-info btn-sm"><i class="fa-solid fa-bars-staggered"></i> {{__('Option')}}</a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                    {{$questions->links('pagination::bootstrap-4')}} 
                    </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="questionsAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{__('Add New Questions')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(array('route' => 'admin.save.question', 'method'=>'POST')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label><strong>{{__('Question')}}</strong></label>
                        {!! Form::text('question', null, array('class' => 'form-control')) !!}
                        <input class="form-control" name="match_id" type="hidden" value="{{$match_id->id}}">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label><strong>{{__('End Date')}}</strong></label>
                            <div class="input-group date">
                                <input type="text" id="pickupDate" class="form-control datepicker-field" data-language="en"
                                    data-position='bottom left' name="end_date" autocomplete="off">
                                <span class="input-group-addon input-group-text"><span class="fa fa-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label><strong>{{__('End Time')}}</strong></label>
                            {!! Form::time('end_time', null, array('placeholder' => 'end_time','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="text-danger">{{__('Date & Time must be set Before')}} {{date('d M, Y - h:i A', strtotime($match_id->end_date))}}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">{{__('Submit')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="editQuestionsModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">{{__('Edit Questions')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'admin.update.question', 'method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Question')}}</strong></label>
                    <input class="form-control edit_qus_question" name="question" required>
                    <input class="form-control edit_qus_id" name="id" type="hidden" value="">
                    <input class="form-control" name="match_id" type="hidden" value="{{$match_id->id}}">
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label><strong>{{__('End Date')}}</strong></label>
                        <div class="input-group date">
                            <input type="text" id="pickupDate" class="form-control edit_qus_date datepicker-field2" data-language="en"
                                data-position='bottom left' name="end_date" autocomplete="off">
                            <span class="input-group-addon input-group-text"><span class="fa fa-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><strong>{{__('End Time')}}</strong></label>
                        {!! Form::time('end_time', date('H:i'), array('placeholder' => 'end_time','class' => 'form-control edit_qus_time')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <p class="text-danger">{{__('Date & Time must be set Before')}} {{date('d M, Y h:i A', strtotime($match_id->end_date))}}</p>
                </div>
                <div class="form-group">
                <label><strong>{{__('Status')}}</strong></label>
                    <select class="form-select edit_qus_status" name="status">
                        <option value="1">{{__('Active')}}</option>
                        <option value="0">{{__('Inactive')}}</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{__('Update')}}</button>
            </div>
        {!! Form::close() !!}
    </div>
    </div>
</div>

@endsection
