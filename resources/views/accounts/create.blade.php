@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('account.create_account')}}</div>

					<div class="card-body">
						{!! Form::open(['action' => 'BankAccountController@store', 'method' => 'POST']) !!}
						<div class="form-group">
							{{Form::label('name', __('account.name'))}}
							{{Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('account.name')])}}
						</div>
						<div class="form-group">
							{{Form::label('account_number', __('account.account_number'))}}
							{{Form::text('account_number', '', ['class' => 'form-control', 'placeholder' => __('account.account_number')])}}
						</div>
						{{Form::submit(__('account.create_account'), ['class' => 'btn btn-primary'])}}
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection