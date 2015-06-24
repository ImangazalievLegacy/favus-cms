@extends('layout.main')

@section('content')

	<h2>Восстановление пароля</h2>

	<form action="{{ URL::route('account.forgot.password-post') }}" method="post">

		<br>Enter your E-mail:<br>
		<input type="text" name="email" size="50" value="{{ (Input::old('email')) ? e(Input::old('email')) : '' }}">
		@if ( $errors->has('email') )
			{{ $errors->first('email') }}
		@endif

		{{ Form::token() }}

		<br><input type="submit" value="Send">
	</form>
	
@stop