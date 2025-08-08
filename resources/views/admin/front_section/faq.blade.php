@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            @can('faq-create')
            <h4 class="card-title text-end"><button type="button" data-bs-toggle="modal" data-bs-target="#faqAddModel" class="btn btn-primary btn-sm">
                    <i class="las la-plus"></i>
                {{__('Add New')}}
            </button></h4>
            @endcan
            <div class="card-body p-0">
                <table class="table s7__table">
                    <thead>
                        <tr>
                            <th>{{__('SL')}}</th>
                            <th>{{__('Question')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faq as $key => $data)
                        <tr>
                            <td>{{$faq->firstItem() + $key}}</td>
                            <td>{{$data->question}}</td>
                            <td>
                                @can('faq-edit')
                                <a href="#editFaqModal" data-route="{{route('faq.update',$data->id)}}" data-bs-toggle="modal" data-question="{{$data->question}}" data-answer="{{$data->answer}}" 
                                    title="Edit" class="btn btn-dark btn-sm editFaqBtn"><i class="las la-edit"></i></a>
                                @endcan
                                @can('faq-destroy')
                                {!! Form::open(['method' => 'DELETE', 'route' => ['faq.destroy', $data->id], 'style' => 'display:inline']) !!}
                                {{ Form::button('<i class="las la-trash"></i>', ['type' => 'submit', 'title' => 'Delete', 'class' => 'btn btn-danger btn-sm myDeletebtn'] )  }}
                                {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="py-4 justify-content-center pagination flex-wrap pagination-rounded-flat pagination-success">
                    {{$faq->links('pagination::bootstrap-4')}} 
                    </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="faqAddModel" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Add New FAQ')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(array('route' => 'faq.store', 'method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Question')}}</strong></label>
                    {!! Form::text('question', null, array('placeholder' => 'Question','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Answer')}}</strong></label>
                    {!! Form::textarea('answer', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

<div class="modal fade" id="editFaqModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">{{__('Edit FAQ')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::open(['id' => 'editFaq', 'method' => 'PATCH']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>{{__('Question')}}</strong></label>
                    {!! Form::text('question', null, array('id' => 'editFaqQuestion', 'placeholder' => 'Question','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label><strong>{{__('Answer')}}</strong></label>
                    {!! Form::textarea('answer', null, array('id' => 'editFaqAnswer', 'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
            </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

@endsection