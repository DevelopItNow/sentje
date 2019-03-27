@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('account.donation_succeeded')}}</div>

					<div class="card-body text-center">
						{{__('account.donation_received')}}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection