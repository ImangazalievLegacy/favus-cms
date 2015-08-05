@extends('layout.main')

@section('title', 'Reset your password')

@section('content')

	<h1 class="accounts-title border bottom">Reset your password</h1>

	<form action="{{ URL::route('account.forgot.password-post') }}" method="post">

		<label for="email" class="large">E-mail</label>
		<input type="email" size="30" name="email" id="email" class="long" value="{{ (Input::old('email')) ? e(Input::old('email')) : '' }}">
		@if ( $errors->has('email') )
			<span class="error">{{ $errors->first('email') }}</span>
		@endif

		<p class="tip">We will send you an email to reset your password.</p>

		{{ Form::token() }}

		<input type="submit" value="Submit"> or <a href="{{ URL::previous() }}">Cancel</a>
	</form>
	
@stop