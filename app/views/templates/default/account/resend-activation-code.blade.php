@extends('layout.main')

@section('content')

	<form action="{{ URL::route('resend.activation.code-post') }}" method="post">

		<br>Email:<br>
		<input type="text" name="email" size="50" value="{{ (Input::old('email')) ? e(Input::old('email')) : '' }}">
		@if ( $errors->has('email') )
			{{ $errors->first('email') }}
		@endif

		{{ Form::token() }}

		<br><input type="submit" value="Send">
	</form>
	
@stop