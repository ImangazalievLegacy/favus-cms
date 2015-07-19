<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="api-url" content="<?php echo 'http://', $_SERVER['HTTP_HOST'], '/api'; ?>">
	<title>@yield('title', Config::get('site/general.sitename', 'Favus CMS'))</title>
	@yield('head')
</head>
<body>
	<h1>{{ Config::get('site/general.sitename', 'Favus CMS') }}</h1>

	@if (Session::has('global'))

		<p>{{ Session::get('global') }}</p>

	@endif

	@include('layout.navigation')
	
	@yield('content')
	<script src="{{ URL::to('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ URL::to('js/api.js') }}"></script>
	@yield('footer')
</body>
</html>