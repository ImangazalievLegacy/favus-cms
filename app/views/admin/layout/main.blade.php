<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') - {{ Config::get('site/general.sitename', 'Favus CMS') }}</title>
	<!-- Bootstrap Core CSS -->
	<link href="{{ URL::to('css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="{{ URL::to('css/admin/sb-admin.css') }}" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="{{ URL::to('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('head')
</head>
<body>
<div id="wrapper">
	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{ URL::route('admin.index') }}">{{ Config::get('site/general.sitename', 'Favus CMS') }}</a>
	</div>
	<!-- Top Menu Items -->
	<ul class="nav navbar-right top-nav pull-right">
		<li>
			<a href="{{ URL::route('home') }}"><i class="fa fa-chevron-right"></i> Вернуться к магазину</a>
		</li>
	</ul>
	<!-- Top Menu Items -->
	<ul class="nav navbar-right top-nav">
	</ul>
	<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
	@include('admin.layout.navigation')
	<!-- /.navbar-collapse -->
	</nav>
	<div id="page-wrapper">
		<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">@yield('title') </h1>
					<div id="alerts">
						@if (Session::has('global'))

							<div class="alert alert-info" role="alert">
								{{ Session::get('global') }}
							</div>

						@endif
					</div>
					

					@yield('content')
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->
</div>
<!-- jQuery -->
<script src="{{ URL::to('js/jquery-2.1.4.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::to('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('js/main.js') }}"></script>
@yield('footer')
</body>
</html>