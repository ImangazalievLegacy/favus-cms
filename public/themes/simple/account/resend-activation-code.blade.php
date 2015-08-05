@extends('layout.main')

@section('title', 'Resend activation code')

@section('content')

	<h1 class="accounts-title border bottom">Resend activation code</h1>

	<form action="{{ URL::route('resend.activation.code-post') }}" method="post">

		<label for="email" class="large">E-mail</label>
		<input type="email" size="30" name="email" id="email" class="long" value="{{ (Input::old('email')) ? e(Input::old('email')) : '' }}">
		@if ( $errors->has('email') )
			<span class="error">{{ $errors->first('email') }}</span>
		@endif

		{{ Form::token() }}

		<input type="submit" class="button" value="Send code">
	</form>
	
@stop