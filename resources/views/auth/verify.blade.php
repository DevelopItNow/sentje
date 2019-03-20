@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.verify') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.linksent') }}
                        </div>
                    @endif

                    {{ __('auth.proceed') }}
                    {{ __('auth.notreceived') }}, <a href="{{ route('verification.resend') }}">{{ __('auth.clickhere') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
