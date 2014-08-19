@extends('layout.default')

@section('content')
<div class="container">
	<div class="col-md-4 centered-form box">
		<h2>Recover my password</h2>
		{{ Form::open(['route' => ['reminder_post_passwordReset']]) }}
		
			<input type="hidden" name="token" value="{{ $token }}">

			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="E-mail">
			</div>

			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="{{ trans('common.password') }}">
			</div>

			<div class="form-group">
				<input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('common.password') }} confirmation">
			</div>
			
			<button type="submit" class="btn btn-primary btn-block">Send</button>

		{{ Form::close() }}
	</div>
</div>
@stop