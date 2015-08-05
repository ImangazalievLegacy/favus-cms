@extends('layout.main')

@section('title', 'Login')

@section('content')

	<h1 class="accounts-title border bottom">Login</h1>

	<form action="{{ URL::route('account.login-post') }}" method="post">

		<label for="email" class="large">E-mail</label>
		<input type="email" size="30" name="email" id="email" class="long" value="{{ (Input::old('email')) ? e(Input::old('email')) : '' }}">
		@if ( $errors->has('email') )
			<span class="error">{{ $errors->first('email') }}</span>
		@endif

		<label for="password" class="large">Password</label>
		<input type="password" size="30" name="password" id="password" class="long" value="">
		@if ( $errors->has('password') )
			<span class="error">{{ $errors->first('password') }}</span>
		@endif

		<input type="checkbox" id="remember" name="remember">
		<span>Remember me</span>

		<div><a href="{{ URL::route('account.forgot.password') }}">Forgot password?</a></div>
		
		{{ Form::token() }}

		<div><input type="submit" value="Send"></div>
	</form>

@stop