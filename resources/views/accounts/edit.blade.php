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
						<table class="table table-striped table-hover">
							<thead>
							<tr>
								<th colspan="2">{{__('account.income')}}</th>
							</tr>
							</thead>
							<tbody>
						@foreach($planned_payments as $planned_payment)
							<tr>
								<td>{{decrypt($planned_payment->payment_name)}}</td>
                                <td>+ €{{ $planned_payment->amount}}</td>
							</tr>
						@endforeach
                        @foreach($payment_requests as $payment_request)
                            @foreach($payment_request->RequestUsers as $request_user)
                                @if($request_user->paid == 1)
                                    <tr>
                                        <td>{{decrypt($payment_request->name)}}</td>
                                        <td>+ €{{ $payment_request->amount}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        @foreach($donations as $donation)
                            <tr>
                                <td>{{decrypt($donation->name)}}</td>
                                <td>+ €{{ $donation->amount}}</td>
                            </tr>
                        @endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@include('inc.modal', ['title'=>__('account.delete_account'), 'body' => __('account.delete_confirm'),
		'action' => 'BankAccountController@destroy', 'id' => $account->id, 'method' => 'DELETE', 'buttonText' => __('account.delete')])