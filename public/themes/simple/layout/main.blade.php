<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="api-url" content="<?php echo 'http://', $_SERVER['HTTP_HOST'], '/api'; ?>">
	<title>@yield('title', Config::get('site/general.sitename', 'Favus'))</title>
	<link rel="stylesheet" href="{{ theme_asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ theme_asset('assets/css/main.css') }}">
	@yield('head')
</head>
<body>
	<div id="wrap">
		<!-- Header -->
		@include('layout.header')
		<!-- Body -->
		@include('layout.body')
	</div>
		<!-- Footer -->
		@include('layout.footer')

	<script src="{{ theme_asset('assets/js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ theme_asset('assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ theme_asset('assets/js/main.js') }}"></script>
	<script src="{{ URL::to('js/api.js') }}"></script>
	@yield('scripts')
</body>
</html>