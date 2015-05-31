<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', Config::get('site/general.sitename', 'Favus CMS'))</title>
</head>
<body>
	<h1>{{ Config::get('site/general.sitename', 'Favus CMS') }}</h1>

	@if (Session::has('global'))

		<p>{{ Session::get('global') }}</p>

	@endif

	@include('layout.navigation')
	
	@yield('content')
</body>
</html>