@extends('layout.main')

@section('title') Главная страница @stop

@section('content')

	<h2>Главная страница</h2>

	@if (Auth::check())
		<p>Hello {{ Auth::user()->username }}</p>
	@else
		<p>You are not signed in</p>
	@endif

@stop