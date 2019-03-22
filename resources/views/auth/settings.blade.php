@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('auth.settings')}}</div>

					<div class="card-body">
						{!! Form::open(['action' => 'SettingsController@update', 'method' => 'POST']) !!}
						<div class="form-group">
							{{Form::label('name', __('account.name'))}}
							{{Form::text('name', decrypt($user->name), ['class' => 'form-control', 'placeholder' => __('account.name')])}}
						</div>
						<div class="form-group">
							{{Form::label('name', 'Dropbox Token')}}
							@if($user->dropbox_token == null)
								{{Form::text('dropbox_token', null, ['class' => 'form-control', 'placeholder' => 'Dropbox Token'])}}
							@else
								{{Form::text('dropbox_token', decrypt($user->dropbox_token), ['class' => 'form-control', 'placeholder' => 'Dropbox Token'])}}
							@endif
						</div>
						{{Form::hidden('_method', 'PUT')}}
						{{Form::submit(__('auth.edit_settings'), ['class' => 'btn btn-primary'])}}
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection