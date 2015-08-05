@extends('layout.main')

@section('title', 'Registration')

@section('content')

	<h1 class="accounts-title border bottom">Registration</h1>

	<form action="{{ URL::route('account.create-post') }}" method="post">

		<label for="username" class="large">Username</label>
		<input type="text" size="30" name="username" id="username" class="long" value="{{ (Input::old('username')) ? e(Input::old('username')) : '' }}">
		@if ( $errors->has('username') )
			<span class="error">{{ $errors->first('username') }}</span>
		@endif

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

		{{ Form::token() }}

		<input type="submit" value="Register">
	</form>

@stop