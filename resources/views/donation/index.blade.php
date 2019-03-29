@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('account.donation')}} {{decrypt($user->name)}}</div>

					<div class="card-body text-center">

						@if($user->donation_account == null)
							{{__('account.disable_donation')}}
						@else


							{!! Form::open(['action' => 'DonationController@donate', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
							<div class="form-group">
								{{Form::label('name', __('request.name'))}}
								{{Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('request.name')])}}
							</div>
							<div class="form-group">
								{{Form::label('amount', __('request.amount'))}}
								{{Form::number('amount', '', ['class' => 'form-control','step'=>'any', 'placeholder' => __('request.amount')])}}
							</div>
							<div class="form-group">
								{{Form::label('currency', __('request.currency'))}}

								<br>
								{{Form::select('currency', ['euro' => 'Euro', 'pound' => __('request.pound')], ['class' => 'form-control', 'placeholder' => __('request.currency')])}}
							</div>
							{{Form::hidden('id', $user->id)}}
							{{Form::submit(__('account.donate'), ['class' => 'btn btn-primary'])}}
							{!! Form::close() !!}
						@endif

					</div>
				</div>
			</div>
		</div>
@endsection