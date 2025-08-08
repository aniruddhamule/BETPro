@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table s7__table">
                <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Subject')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($email_templates as $key => $data)
                    <tr>
                        <td>{{$email_templates->firstItem() + $key}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->subj}}</td>
                        <td>@if ($data->email_status == 1)
                            <span class="badge bg-success">{{__('Active')}}</span>
                            @else
                            <span class="badge bg-warning">{{__('Disabled')}}</span>
                            @endif
                        </td>
                        <td>
                            @can('email-template-edit')
                            <a href="{{route('email-template.edit', $data->id)}}" class="btn btn-dark btn-sm"><i class="las la-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                {{$email_templates->links('pagination::bootstrap-4')}} 
                </div>
        </div>
    </div>

@endsection

