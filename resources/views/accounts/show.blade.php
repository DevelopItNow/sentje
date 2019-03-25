@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">Account
					</div>

					<div class="card-body">
						<div class="form-group">
							<p><strong>{{__('account.name')}}</strong>: {{decrypt($account->name)}}</p>
						</div>
						<div class="form-group">
							<p><strong>{{__('account.account_number')}}</strong>: {{decrypt($account->account_number)}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
