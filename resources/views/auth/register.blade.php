@extends('fulllayout')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{ Lang::get('site.reg_heading') }}</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ Lang::get('validation.errors_heading') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_title') }}</label>
							<div class="col-md-6">
								{{-- <select class="form-control" name="title" value="{{ old('title') }}">
						  			<option value="Mr">Mr.</option>
								  	<option value="Mrs">Mrs.</option>
								  	<option value="Ms">Ms.</option>
								</select> --}}

								{!! Form::select('title', $titles, 'default', ['class' => 'form-control'] ) !!}

							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_firstname') }}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_lastname') }}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_mobile') }}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_email') }}</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_password') }}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_confirm_password') }}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>	

						<div class="form-group">
							<label class="col-md-4 control-label">{{ Lang::get('site.reg_newsletter') }}</label>
							<div class="col-md-1">
								<input type="checkbox" class="form-control" name="newsletter" value="Y" checked>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									{{ Lang::get('site.reg_btn') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
