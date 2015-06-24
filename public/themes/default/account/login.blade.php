@extends('layout.main')

@section('content')

	<h2>Форма входа</h2>

	<form action="{{ URL::route('account.login-post') }}" method="post">

		<br>Email:<br>
		<input type="text" name="email" size="50" value="{{ (Input::old('email')) ? e(Input::old('email')) : '' }}">
		@if ( $errors->has('email') )
			{{ $errors->first('email') }}
		@endif

		<br>Password:<br>
		<input type="text" name="password" size="30">
		@if ( $errors->has('password') )
			{{ $errors->first('password') }}
		@endif

		<br><input type="checkbox" id="remember" name="remember">
		<label for="remember">Remember me</label>
		
		{{ Form::token() }}

		<br><input type="submit" value="Sign in">
	</form>
	<br>
	<a href="{{ URL::route('account.forgot.password') }}">Forgot password?</a>

@stop