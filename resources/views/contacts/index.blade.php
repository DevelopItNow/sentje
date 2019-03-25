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
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{__('account.name')}}</th>
                                    <th>{{__('account.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{decrypt($contact->user->name)}}</td>
                                        <td>
                                            {!!Form::open(['action' => ['ContactController@destroy', $contact->user->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit(__('contact.delete_contact'), ['class' => 'btn btn-danger btn-block'])}}
                                            {!!Form::close()!!}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">{{$contacts->links()}}</td>
                                </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
