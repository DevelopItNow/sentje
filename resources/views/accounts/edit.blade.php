@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('account.edit_account')}}
						<p class="float-right">
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#openModal">
								{{__('account.delete_account')}}
							</button>
						</p>
					</div>

					<div class="card-body">
						{!! Form::open(['action' => ['BankAccountController@update', $account->id], 'method' => 'POST']) !!}
						<div class="form-group">
							{{Form::label('name', __('account.name'))}}
							{{Form::text('name', decrypt($account->name), ['class' => 'form-control', 'placeholder' => __('account.name')])}}
						</div>
						<div class="form-group">
							{{Form::label('account_number', __('account.account_number'))}}
							{{Form::text('account_number', decrypt($account->account_number), ['class' => 'form-control', 'placeholder' => __('account.account_number')])}}
						</div>
						{{Form::hidden('_method', 'PUT')}}
						{{Form::submit(__('account.edit_account'), ['class' => 'btn btn-primary'])}}
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@include('inc.modal', ['title'=>__('account.delete_account'), 'body' => __('account.delete_confirm'),
		'action' => 'BankAccountController@destroy', 'id' => $account->id, 'method' => 'DELETE', 'buttonText' => __('account.delete')])