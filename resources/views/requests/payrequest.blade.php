@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{$request->nameRequest}}</div>

					<div class="card-body text-center">
						<div class="form-group">
							<p class="user-information font-weight-bold">{{__('request.amount')}}</p>
							@if($request->currency == 'euro')
								€
							@else
								£
							@endif
							{{number_format($request->amount, 2)}}
						</div>
						<div class="form-group">
							<p class="user-information font-weight-bold">{{__('request.description')}}</p>
							{{$request->descRequest}}
						</div>
						<div class="form-group">
							@if($request->image != null)
								<tr>
									<td class="font-weight-bold">{{__('request.image')}}</td>
									<td><img src="/storage/added_image/{{$request->image}}" style="max-width: 100%"></td>
								</tr>
							@endif
						</div>
						@if($request->paid == 0)
							{!!Form::open(['route' => ['pay', $request->amount, $request->currency, 'request', $request->id], 'method' => 'POST'])!!}

							<div class="form-group">
								{{Form::label('note', __('request.add_note'), ['class' => 'font-weight-bold'])}}
								{{Form::text('note', '', ['class' => 'form-control', 'placeholder' => __('request.note')])}}
							</div>
							{{Form::submit(__('calendar.pay_planned_payment'), ['class' => 'btn btn-success'])}}
							{!! Form::close() !!}
						@else
							<p>{{__('request.paidmessage')}}</p>
							<p>{{__('request.paid_on')}} {{$request->updated_at}}</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection