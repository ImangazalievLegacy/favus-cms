@extends('layout.main')

@section('title', 'Reset your password')

@section('content')

	<h1 class="accounts-title border bottom">Reset your password</h1>

	<form action="{{ URL::route('account.password.reset-post') }}" method="post">

		<label for="password" class="large">Password</label>
		<input type="password" size="30" name="password" id="password" class="long" value="">
		@if ( $errors->has('password') )
			<span class="error">{{ $errors->first('password') }}</span>
		@endif

		<input type="hidden" name="code" value="{{ (Input::old('code')) ?  e(Input::old('code')) : $code }}">

		{{ Form::token() }}

		<input type="submit" value="Reset">
	</form>
	
@stop