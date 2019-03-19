@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="links text-center">
                        <a href="">{{__('dashboard.account')}}</a>
                        <a href="">{{__('dashboard.request')}}</a>
                        <a href="">{{__('dashboard.group')}}</a>
                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Overview
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">{{__('dashboard.accounts')}}</a>
                            <a class="dropdown-item" href="#">{{__('dashboard.requests')}}</a>
                            <a class="dropdown-item" href="#">{{__('dashboard.groups')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
