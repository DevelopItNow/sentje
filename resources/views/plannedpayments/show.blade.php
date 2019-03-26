@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{__('calendar.pay_planned_payment_header')}}</div>

                    <div class="card-body text-center">

                        <div class="form-group">
                            <p class="user-information font-weight-bold">{{__('calendar.sender_name')}}</p>
                            {{decrypt($sender->name)}}
                        </div>
                        <div class="form-group">
                            <p class="user-information font-weight-bold">{{__('calendar.date')}}</p>
                            {{date('d-m-Y', strtotime($planned_payment->planned_date))}}
                        </div>
                        <div class="form-group">
                            <p class="user-information font-weight-bold">{{__('calendar.amount')}}</p>
                            @if($planned_payment->currency = 'euro')
                                €
                                @else
                                £
                            @endif
                            {{$planned_payment->amount}}
                        </div>
                        <div class="form-group">
                            <p class="user-information font-weight-bold">{{__('calendar.description')}}</p>
                            {{decrypt($planned_payment->description)}}
                        </div>
                        @if(date('Y-m-d') < $planned_payment->planned_date)
                            {!! Form::open(['action' => ['PlannedPaymentController@update', $planned_payment->id],  'method' => 'POST']) !!}
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::submit(__('calendar.pay_planned_payment'), ['class' => 'btn btn-primary'])}}
                            {!! Form::close() !!}
                            @else
                            <p class="user-information font-weight-bold">{{__('calendar.payment_not_available')}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection