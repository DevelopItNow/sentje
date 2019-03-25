@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('dashboard.dashboard')}}</div>

					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						@include('inc.dashboard_header')
						<table class="table table-striped table-hover">
							<thead>
							<tr>
								<th>{{__('request.name')}}</th>
								<th>{{__('request.created_at')}}</th>
								<th>{{__('request.action')}}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($requests as $request)
								<tr>
									<td><a href="/request/{{$request->id}}">{{decrypt($request->name)}}</a></td>
									<td>{{date('d-m-Y', strtotime($request->created_at))}}</td>
									<td>
										<a href="/request/{{$request->id}}/edit" class="settings" title="Settings"
										   data-toggle="tooltip">{{__('request.edit')}}</a>
									</td>
								</tr>
							@endforeach
							<tr>
								<td colspan="5">{{$requests->links()}}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
