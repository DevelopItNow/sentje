@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{__('group.create_group')}}</div>

                    <div class="card-body">
                        {!! Form::open(['action' => 'GroupController@store', 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('name', __('account.name'))}}
                            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('account.name')])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('description', __('group.description'))}}
                            {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => __('group.description')])}}
                        </div>
                        {{Form::submit(__('group.create_group'), ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection