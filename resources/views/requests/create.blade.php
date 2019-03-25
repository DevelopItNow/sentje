@extends('layouts.app')
@section('content')
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
							{{Form::label('currency', __('request.currency'))}}
							<br>
							{{Form::select('currency', ['euro' => 'Euro', 'pound' => __('request.pound')], ['class' => 'form-control', 'placeholder' => __('calendar.currency')])}}
						</div>
						<div class="form-group">
							{{Form::file('added_image')}}
						</div>
						<div class="form-group requests">
							<div class="row">
								<div class="col-sm-6">
									<p class="font-weight-bold user-information">{{__('request.add_groups')}}</p><br>
									<table class="user-information">
										@foreach($groups as $group)
											<tr>
												<td>{{$group->name}}</td>
												<td><label class="switch ">
														<input name="group_{{$group->id}}" type="checkbox">
														<span class="slider round"></span>
													</label></td>
											</tr>
										@endforeach
									</table>
								</div>
								<div class="col-sm-6">
									<p class="font-weight-bold user-information">{{__('request.add_users')}}</p><br>
									<table class="user-information">
										@foreach($contacts as $contact)
											<tr>
												<td>{{decrypt($contact['name'])}}</td>
												<td><label class="switch ">
														<input name="contact_{{$contact['id']}}" type="checkbox">
														<span class="slider round"></span>
													</label></td>
											</tr>
										@endforeach
									</table>
								</div>
							</div>
						</div>
						<div class="form-group">
							<table id="myTable" class=" table order-list">
								<thead>
								<tr>
									<td>Mail</td>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td class="col-sm-4">
										<input type="email" name="mail" class="form-control"/>
									</td>
									<td class="col-sm-2"><a class="deleteRow"></a>

									</td>
								</tr>
								</tbody>
								<tfoot>
								<tr>
									<td colspan="5" style="text-align: left;">
										<input type="button" class="btn btn-lg btn-block btn-success" id="addrow"
											   value="{{__('request.add_row')}}"/>
									</td>
								</tr>
								<tr>
								</tr>
								</tfoot>
							</table>
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
            var counter = 0;

            jQuery("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="email" class="form-control" name="mail_' + counter + '"/></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="{{__('request.delete')}}"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                counter++;
            });


            jQuery("table.order-list").on("click", ".ibtnDel", function (event) {
                jQuery(this).closest("tr").remove();
                counter -= 1
            });

        });
	</script>
@endsection