@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <form class="s7__nav-search-form" method="GET">
                        <input type="text" name="search" placeholder="Search..." autocomplete="off">
                        <button type="submit"><i data-feather="search"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('User')}}</th>
                    <th>{{__('Match')}}</th>
                    <th>{{__('Question')}}</th>
                    <th>{{__('Option')}}</th>
                    <th>{{__('Rate')}}</th>
                    <th>{{__('Invest')}}</th>
                    <th>{{__('Return')}}</th>
                    <th>{{__('Status')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($bets as $key => $data)
                    <tr>
                        <td>{{$bets->firstItem() + $key}}</td>
                        <td>
                            <span class="font-weight-bold">{{__($data->user->name)}}</span>
                            <br>
                            <span class="small">
                            <a href="{{ route('user.view', $data->user->id) }}"><span>@</span>{{$data->user->name}}</a>
                            </span>
                        </td>
                        <td>{{$data->match->team_1}} <label class="badge bg-info"> {{__('VS')}} </label> {{$data->match->team_2}}</td>
                        <td>{{__($data->ques->question)}}</td>
                        <td><span class="text-primary">{{__($data->betoption->option_name)}}</span></td>
                        <td>{{$data->ratio}}</td>
                        <td><span class="text-primary">{{getAmount($data->invest_amount)}} {{$general->currency }}</span></td>
                        <td><span class="text--primary">{{getAmount($data->return_amount)}} {{$general->currency }}</span></td>
                        <td>
                            @if ($data->status == 1)
                            <span class="badge bg-success">{{__('Won')}}</span>
                            @elseif ($data->status == 2)
                            <span class="badge bg-secondary">{{__('Refunded')}}</span>
                            @elseif ($data->status == 0)
                            <span class="badge bg-warning">{{__('Panding')}}</span>
                            @elseif ($data->status == -1)
                            <span class="badge bg-danger">{{__('Lost')}}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$bets->links('pagination::bootstrap-4')}} 
            </div>
        </div>
    </div>

@endsection