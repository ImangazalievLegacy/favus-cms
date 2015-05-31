@extends('layout.main')

@section('content')

	<form action="{{ URL::route('account.password.reset-post') }}" method="post">

		<br>Enter new password:<br>
		<input type="text" name="password">
		@if ( $errors->has('password') )
			{{ $errors->first('password') }}
		@endif

		<input type="hidden" name="code" value="{{ (Input::old('code')) ?  e(Input::old('code')) : $code }}">

		{{ Form::token() }}

		<br><input type="submit" value="Reset">
	</form>
	
@stop