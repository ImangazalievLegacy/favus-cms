<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', Config::get('site/general.sitename', 'Favus CMS'))</title>
	<script src="{{ URL::to('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ URL::to('js/main.js') }}"></script>
	@yield('head')
</head>
<body>
	<h1>{{ Config::get('site/general.sitename', 'Favus CMS') }}</h1>

	@if (Session::has('global'))

		<p>{{ Session::get('global') }}</p>

	@endif

	@include('admin.layout.navigation')
	
	@yield('content')
</body>
</html>