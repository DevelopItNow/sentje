@if(count($errors) > 0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger col-md-8 row text-center justify-content-center">
			{{$error}}
		</div>
	@endforeach
@endif

@if(session('success'))
	<div class="alert alert-success col-md-8 row text-center justify-content-center">
		{{session('success')}}
	</div>
@endif

@if(session('error'))
	<div class="alert alert-danger col-md-8 row text-center justify-content-center">
		{{session('error')}}
	</div>
@endif