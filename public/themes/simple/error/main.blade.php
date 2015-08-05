@extends('layout.main')

@section('content')

<div id="breadcrumb">
	<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
		<a href="{{ URL::route('home') }}" itemprop="url">
			<span itemprop="title">Home</span>
		</a>
	</span>
	—
	<a href="{{ URL::route('home') }}" class="active">@yield('error-title')</a>
</div>

<h1>@yield('error-title').</h1>

<div id="http-error">
	<h2>@yield('error-code')</h2>
	<p>@yield('error-description', '')</p>
</div>

@stop