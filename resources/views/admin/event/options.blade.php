@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-md-7 text-start">
                        @if (!is_null($ques->match->team_1_image))
                            <img class="bet-flag-img" src="{{asset('public/images/match/'.$ques->match->team_1_image)}}" alt="img">
                        @endif
                         {{$ques->match->team_1}} <label class="badge badge-info">  {{__('VS')}} </label>  
                         @if (!is_null($ques->match->team_2_image))
                            <img class="bet-flag-img" src="{{asset('public/images/match/'.$ques->match->team_2_image)}}" alt="img"> 
                         @endif
                         {{$ques->match->team_2}}
                    </div>
                    <div class="col-md-5 text-end">
                        <h4 class="card-title text-end">
                            <a href="{{route('admin.view.question',$ques->match->id )}}" class="btn s7__btn-dark btn-sm @if(Request::routeIs('admin.view.question')) active @endif">
                            <i class="las la-arrow-left"></i> {{__('Go Back')}}
                            </a>
                            @can('admin-createnewoption')
                            <button type="button" data-bs-toggle="modal" data-bs-target="#optionAddModel" class="btn s7__btn-primary btn-sm">
                                <i class="las la-plus"></i> {{__('Add Option')}}</button>
                            @endcan
                        </h4>
                    </div>
                </div>
            </h4>
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Thread')}}</th>
                    <th>{{__('Ratio')}}</th>
                    <th>{{__('Total Predict Amount')}}</th>
                    <th>{{__('Total Return Amount')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($betoption as $key => $data)
                    <tr>
                        <td>{{$betoption->firstItem() + $key}}</td>
                        <td>{{$data->option_name}}</td>
                        <td>{{$data->ratio1}} X {{$data->ratio2}}</td>
                        @php
                            $investAmo = App\Models\BetInvest::where('betoption_id',$data->id)->where('status','!=',2)->sum('invest_amount');
                            $giveBackAmo = App\Models\BetInvest::where('betoption_id',$data->id)->where('status','!=',2)->sum('return_amount');
                        @endphp
                        <td><strong>{{number_format($investAmo,2)}} {{$general->currency}} </strong></td>
                        <td><strong>{{number_format($giveBackAmo,2)}} {{$general->currency}} </strong></td>
                        <td>
                            @if ($data->status == 1)
                            <span class="badge bg-success">{{__('Active')}}</span>
                            @else
                            <span class="badge bg-warning">{{__('Disabled')}}</span>
                            @endif
                        </td>
                        <td>
                            @can('admin-update-option')
                            <button type="button"
                                class="btn s7__btn-secondary btn-sm editOptionBtn"
                                title="Edit"
                                data-bs-toggle="modal" data-bs-target="#editOptionModal"
                                data-act="Edit"
                                data-name="{{$data->option_name}}"
                                data-invest="{{$data->invest_amount}}"
                                data-minamo="{{$data->min_amo}}"
                                data-retrunamo="{{$data->return_amount}}"
                                data-ratio1="{{$data->ratio1}}"
                                data-ratio2="{{$data->ratio2}}"
                                data-bet="{{$data->bet_ratio}}"
                                data-status="{{$data->status}}"
                                data-bet_limit="{{$data->bet_limit}}"
                                data-id="{{$data->id}}">
                                <i class="las la-edit"></i>
                            </button>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$betoption->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

<div class="modal fade" id="optionAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Add Option')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'admin.createNewOption', 'method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Option Name')}}</strong></label>
                    {!! Form::text('option_name', null, array('class' => 'form-control')) !!}
                    <input class="" type="hidden" value="{{$ques->id}}" name="ques_id">
                    <input class="" type="hidden" value=" {{$ques->match->id}}" name="match_id">
                </div>
                <div class="form-group">
                    <label><strong>{{__('Minimum Batting Amount')}}</strong></label>
                    {!! Form::number('min_amo', null, array('class' => 'form-control', 'step' => 'any', 'required')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Maximum Batting Amount')}}</strong></label>
                    {!! Form::number('bet_limit', null, array('class' => 'form-control', 'step' => 'any', 'required')) !!}
                </div>
                <div class="form-group row">
                    <label><strong>{{__('Ratio')}}</strong></label>
                    <div class="col">
                        <input type="number" name="ratio1" class="form-control" value="1" readonly>
                    </div>
                    X
                    <div class="col">
                        <input  type="number" class="form-control" step="0.01" name="ratio2" required>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{__('Submit')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

<div class="modal fade" id="editOptionModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{__('Edit Option')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" action="{{route('admin.update.option')}}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Option Name')}}</strong></label>
                    <input class="form-control subro_id" type="hidden" name="id">
                    <input class="form-control input-lg subro_question" type="text" name="option_name"  required>
                </div>

                <div class="form-group">
                    <label><strong>{{__('Minimum Batting Amount')}}</strong></label>
                    <input class="form-control input-lg subro_minamo" name="min_amo" step="any" type="number" required>
                </div>


                <div class="form-group">
                    <label><strong>{{__('Maximum Batting Amount')}}</strong></label>
                    <input class="form-control input-lg subro_bet_limit" name="bet_limit" step="any" type="number" required>
                </div>

                <div class="form-group row">
                    <label><strong>{{__('Ratio')}}</strong></label>
                    <div class="col">
                        <input type="number" class="form-control subro_ratio1" step="0.01" name="ratio1" readonly required>
                    </div>
                    X
                    <div class="col">
                        <input type="number" class="form-control subro_ratio2 " step="0.01" name="ratio2"  required>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>{{__('Status')}}</strong></label>
                    <select name="status" class="form-select subro_status" required>
                        <option value="1">{{__('Active')}}</option>
                        <option value="0">{{__('DeActive')}}</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{__('Update')}}</button>
            </div>
        </form>
    </div>
    </div>
</div>

@endsection
