@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{__('calendar.create_planned_payment')}}</div>

                    <div class="card-body">
                        {!! Form::open(['action' => 'PlannedPaymentController@store', 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('name', __('account.name'))}}
                            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('account.name')])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('email', __('calendar.email_receiver'))}}
                            {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => __('auth.email')])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('date', __('calendar.date'))}}
                            {{Form::text('date', '', ['class' => 'form-control date', 'placeholder' => __('calendar.date')])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('currency', __('calendar.currency'))}}
                            <br>
                            {{Form::select('currency', ['euro' => 'Euro', 'pound' => __('calendar.pound')], ['class' => 'form-control', 'placeholder' => __('calendar.currency')])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('amount', __('calendar.amount'))}}
                            {{Form::number('amount', '', ['class' => 'form-control', 'placeholder' => __('calendar.amount')])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('description', __('group.description'))}}
                            {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => __('group.description')])}}
                        </div>
                        {{Form::submit(__('calendar.create_planned_payment'), ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection