@extends('layouts.app')
@section('content')
	{{dd($contacts)}}
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{__('request.create_request')}}</div>

					<div class="card-body">
						{!! Form::open(['action' => 'RequestController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
						<div class="form-group">
							{{Form::label('name', __('request.name'))}}
							{{Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('request.name')])}}
						</div>

						<div class="form-group">
							{{Form::label('description', __('request.description'))}}
							{{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => __('request.description')])}}
						</div>

						<div class="form-group">
							{{Form::label('amount', __('request.amount'))}}
							{{Form::number('amount', '', ['class' => 'form-control','step'=>'any', 'placeholder' => __('request.amount')])}}
						</div>
						<div class="form-group">
							{{Form::file('added_image')}}
						</div>
						<div class="form-group">

						</div>


						{{Form::submit(__('request.create_request'), ['class' => 'btn btn-primary'])}}
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
        jQuery(document).ready(function () {

        });
	</script>
@endsection