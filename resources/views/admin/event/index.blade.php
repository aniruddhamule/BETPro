@extends('admin.layouts.master')
@section('content')    
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                @can('tournament-index')
                <form class="s7__nav-search-form" method="GET">
                    <input type="text" name="search" placeholder="Search..." autocomplete="off">
                    <button type="submit"><i data-feather="search"></i></button>
                </form>
                @endcan
                <div class="d-flex flex-wrap justify-content-end align-items-center">
                    @can('admin-add-match')
                    <h4 class="card-title text-end">
                        <button data-bs-toggle="modal" data-bs-target="#eventAddModel" type="button" class="btn s7__btn-primary btn-sm">
                            <i class="las la-plus"></i>
                            {{__('Add New')}}
                        </button>
                    </h4>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                    <tr>
                        <th>{{__('SL')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Category')}} | {{__('Tournament')}}</th>
                        <th>{{__('Start At')}} | {{__('End At')}}</th>
                        <th>{{__('Predict Amount')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matches as $key => $data)
                    <tr>
                        <td>{{$matches->firstItem() + $key}}</td>
                        <td class="text-center">@if(!is_null($data->team_1_image))<img class="bet-flag-img" src="{{asset('public/images/match/'.$data->team_1_image)}}" alt="img">@endif 
                            <span>{{$data->team_1}}</span>
                            <br> 
                            <label class="badge bg-info"> {{__('VS')}} </label>
                            <br>
                            <span>{{$data->team_2}}</span>
                            @if(!is_null($data->team_2_image))<img class="bet-flag-img" src="{{asset('public/images/match/'.$data->team_2_image)}}" alt="img">@endif 
                        </td>
                        <td class="text-center"><span class="font-weight-bold">{{__($data->cat->name)}}</span>
                            <br>
                            {{__($data->event->name)}}
                        </td>
                        <td>
                            <strong>{{ date('d M Y, h:i A', strtotime($data->start_date)) }}</strong>
                            <br>
                            <strong>{{date('d M Y, h:i A', strtotime($data->end_date))}}</strong>
                        </td>
                        <td>
                            @if($data->betInvests->sum('invest_amount') > 0)
                            <p class="text-danger">{{number_format($data->betInvests->where('status','!=',2)->sum('invest_amount'),2) }} {{$general->currency}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($data->status == 1)
                            <span class="badge bg-success">{{__('Active')}}</span>
                            @else
                            <span class="badge bg-warning">{{__('Disabled')}}</span>
                            @endif
                        </td>
                        <td>
                            @can('admin-edit-match')
                                <a href="#editEventModal{{$data->id}}" data-bs-toggle="modal" class="btn s7__btn-secondary btn-sm" title="Edit Event"><i class="las la-edit"></i></a>
                            @endcan
                            @php
                                $totalQuestions = $data->questions()->count();
                                $totalOptions = $data->options()->count();
                            @endphp
                            @can('admin-view-question')
                                <a href="{{route('admin.view.question', $data->id )}}" title="{{$totalQuestions}} Question" class="btn s7__btn-info btn-sm">
                                    <i class="las la-question"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>

                    <div class="modal fade" id="editEventModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">{{__('Edit Event')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                {!! Form::model($data, ['method' => 'PUT','route' => ['admin.update.match', $data->id], 'class' => 'forms-sample', 'enctype' => 'multipart/form-data']) !!}
                                <div class="modal-body">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label><strong>{{__('Select Tournament')}} <span class="text-danger">*</span></strong></label>
                                                <select name="event_id" class="form-select" required>
                                                    <option value="" selected disabled>{{__('Select Tournament')}}</option>
                                                    @foreach($tournaments as $item)
                                                    <option value="{{$item->id}}" @if($data->event_id == $item->id) selected @endif>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><strong>{{__('Status')}} <span class="text-danger">*</span></strong></label>
                                                <select class="form-select" name="status">
                                                    <option value="1" {{$data->status==1?'selected':''}}>{{__('Active')}}</option>
                                                    <option value="0" {{$data->status==0?'selected':''}}>{{__('Inactive')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label><strong>{{__('Start Date & Time')}} <span class="text-danger">*</span></strong></label>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" id="pickupDate" class="form-control datepicker-field" value="{{date('d/m/Y',strtotime($data->start_date))}}" data-language="en"
                                                        data-position='bottom left' name="start_date" autocomplete="off">
                                                        <span class="input-group-addon input-group-text"><span class="fa fa-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::time('start_time', date('H:i',strtotime($data->start_date)), array('placeholder' => 'start_time','class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label><strong>{{__('End Date & Time')}} <span class="text-danger">*</span></strong></label>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input type="text" id="pickupDate" class="form-control datepicker-field2" value="{{date('d/m/Y',strtotime($data->end_date))}}" data-language="en"
                                                        data-position='bottom left' name="end_date" autocomplete="off">
                                                        <span class="input-group-text">
                                                            <span class='fa fa-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::time('end_time', date('H:i',strtotime($data->end_date)), array('placeholder' => 'end_time','class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label><strong>{{__('Team 01')}} <span class="text-danger">*</span></strong></label>
                                                {!! Form::text('team_1', null, array('placeholder' => 'Team 01','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label><strong>{{__('Team 02')}} <span class="text-danger">*</span></strong></label>
                                                {!! Form::text('team_2', null, array('placeholder' => 'Team 02','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::file('team_1_image', array('id' => 'file-input', 'class' => 'form-control')) !!}
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div id='img_contain'>
                                                            @if (!is_null($data->team_1_image))
                                                                <img id="image-preview" class="img-fluid" src="{{asset('public/images/match/'.$data->team_1_image)}}" alt="image" />
                                                            @else
                                                                <img id="image-preview" class="img-fluid" src="{{asset('public/images/no-image.png')}}" alt="image" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::file('team_2_image', array('id' => 'file-input2', 'class' => 'form-control')) !!}
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div id='img_contain'>
                                                            @if (!is_null($data->team_2_image))
                                                                <img id="image-preview2" class="img-fluid" src="{{asset('public/images/match/'.$data->team_2_image)}}" alt="image" />
                                                            @else
                                                                <img id="image-preview2" class="img-fluid" src="{{asset('public/images/no-image.png')}}" alt="image" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn s7__btn-primary">{{__('Update')}}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$matches->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>

<div class="modal fade" id="eventAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">{{__('Add New Event')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(array('route' => 'admin.store.match', 'class' => 'forms-sample', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="form-group">
                        <label><strong>{{__('Select Tournament')}} <span class="text-danger">*</span></strong></label>
                        <select name="event_id" class="form-select" required>
                            <option value="" selected disabled>{{__('Select Tournament')}}</option>
                            @foreach($events as $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label><strong>{{__('Start Date & Time')}} <span class="text-danger">*</span></strong></label>
                            <div class="col-sm-6">
                                <div class="input-group date">
                                    <input type="text" id="pickupDate" class="form-control datepicker-field" data-language="en"
                                        data-position='bottom left' name="start_date" autocomplete="off">
                                    <span class="input-group-addon input-group-text"><span class="fa fa-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    {!! Form::time('start_time', null, array('placeholder' => 'start_time','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label><strong>{{__('End Date & Time')}} <span class="text-danger">*</span></strong></label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" id="pickupDate" class="form-control datepicker-field2" data-language="en"
                                        data-position='bottom left' name="end_date" autocomplete="off">
                                    <span class="input-group-text">
                                        <span class='fa fa-calendar'></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    {!! Form::time('end_time', null, array('placeholder' => 'end_time','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label><strong>{{__('Team 01')}}</strong> <span class="text-danger">*</span></label>
                            {!! Form::text('team_1', null, array('placeholder' => 'Team 01','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label><strong>{{__('Team 02')}}</strong> <span class="text-danger">*</span></label>
                            {!! Form::text('team_2', null, array('placeholder' => 'Team 02','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::file('team_1_image', array('id' => 'file-input3', 'class' => 'form-control', 'required')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview3" class="img-fluid" src="{{asset('public/images/no-image.png')}}" alt="image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::file('team_2_image', array('id' => 'file-input4', 'class' => 'form-control', 'required')) !!}
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id='img_contain'>
                                        <img id="image-preview4" class="img-fluid" src="{{asset('public/images/no-image.png')}}" alt="image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn s7__btn-primary">{{__('Submit')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection