

<div id="breadcrumb">
	<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
		<a href="{{ URL::route('home') }}" itemprop="url">
			<span itemprop="title">Home</span>
		</a>
	</span>
	—
	<a href="{{ URL::route('home') }}" class="active">@yield('errortitle')</a>
</div>

<h1>@yield('errortitle').</h1>

<div id="http-error">
	<h2>@yield('errorcode')</h2>
	<p>@yield('errordescription', '')</p>
</div>

