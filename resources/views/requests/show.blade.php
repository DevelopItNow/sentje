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
								<td>
									@if($request->currency == 'euro')
										€
									@else
										£
									@endif
									{{number_format($request->amount, 2, localeconv()['decimal_point'], localeconv()['thousands_sep'])}}
								</td>
							</tr>
							@if($request->image != null)
								<tr>
									<td>{{__('request.image')}}</td>
									<td>
										<img src="/storage/added_image/{{$request->image}}" style="max-width: 100%">
									</td>
								</tr>
							@endif
							@if($showDelete == 1)
								<tr>
									<td colspan="2">
										<button type="button" class="btn btn-danger" data-toggle="modal"
												data-target="#openModal">
											{{__('request.delete_request')}}
										</button>
									</td>
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
									@if($user['note'] != null)
										<td>{{__('request.note')}} : {{$user['note']}}</td>
									@endif
								</tr>

							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('inc.modal', ['title'=>__('request.delete_request'), 'body' => __('request.delete_confirm'),
			'action' => 'RequestController@destroy', 'id' => $request->id, 'method' => 'DELETE', 'buttonText' => __('account.delete')])
@endsection