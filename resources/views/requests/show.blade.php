@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('request.request')}} : {{decrypt($request->name)}}</div>
					<div class="card-body">
						<table>
							<tr>
								<td>{{__('request.name')}}</td>
								<td>{{decrypt($request->name)}}</td>
							</tr>
							<tr>
								<td>{{__('request.description')}}</td>
								<td>{{decrypt($request->description)}}</td>
							</tr>
							<tr>
								<td>{{__('request.amount')}}</td>
								<td>{{$request->amount}}</td>
							</tr>
							<tr>
								<td>{{__('request.currency')}}</td>
								<td>{{$request->valuta}}</td>
							</tr>
							@if($request->image != null)
								<tr>
									<td>{{__('request.image')}}</td>
									<td><img src="/storage/added_image/{{$request->image}}"></td>
								</tr>
							@endif
						</table>
						<h2>{{__('request.all_statuses')}}</h2>
						<table>
							@foreach($requestUser as $user)
								<tr>
									<td>{{$user['name']}}</td>
									@if($user['paid'] != 0)
									<td>{{__('request.paid')}}</td>
									@else
									<td>{{__('request.notpaid')}}</td>
									@endif
								</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection