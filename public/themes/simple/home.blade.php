@extends('layout.main')

@section('title') Главная страница @stop

@section('content')

<div class="row">
	<div class="col-md-12">
		<h1>Главная страница</h1>
		<div class="wysiwyg">
				@if (Auth::check())
					<p>Hello, {{ Auth::user()->username }}</p>
				@else
					<p>You are not signed in</p>
				@endif	
		</div>
	</div>
</div>

@stop