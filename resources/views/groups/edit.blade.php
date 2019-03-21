@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{__('group.edit_group')}}
                        <p class="float-right">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#openModal">
                                {{__('group.delete_group')}}
                            </button>
                        </p>
                    </div>

                    <div class="card-body">
                        {!! Form::open(['action' => ['GroupController@update', $group->id], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('name', __('account.name'))}}
                            {{Form::text('name', $group->name, ['class' => 'form-control', 'placeholder' => __('account.name')])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('description', __('group.description'))}}
                            {{Form::textarea('description', $group->description, ['class' => 'form-control', 'placeholder' => __('group.description')])}}
                        </div>
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::submit(__('group.edit_group'), ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@include('inc.modal', ['title'=>__('group.delete_group'), 'body' => __('group.delete_confirm'),
		'action' => 'GroupController@destroy', 'id' => $group->id, 'method' => 'DELETE', 'buttonText' => __('group.delete')])