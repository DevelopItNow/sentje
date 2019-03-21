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
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{__('account.name')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($groups as $group)
                                    <tr>
                                        <td>{{$group->name}}</td>
                                        <td>
                                            <a href="/groups/{{$group->id}}/edit" class="settings" title="Settings"
                                               data-toggle="tooltip">{{__('group.edit')}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">{{$groups->links()}}</td>
                                </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection