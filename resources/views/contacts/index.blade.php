@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{__('dashboard.dashboard')}}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('inc.dashboard_header')
                            <h3 class="text-center mb-4">{{__('contact.addcontact')}}</h3>
                            {!! Form::open(['action' => 'ContactController@store', 'method' => 'POST']) !!}
                            <div class="input-group">
                                {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => __('auth.email')])}}
                                <span class="input-group-btn">
                                    {{Form::submit(__('contact.addcontact'), ['class' => 'btn btn-success'])}}
                                    {!! Form::close() !!}
                                </span>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
