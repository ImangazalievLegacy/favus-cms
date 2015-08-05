<header>
	<div class="container">
		<div class="row upper">
			<div class="wrap col-md-10 col-md-offset-1">
				<div class="search">
					<form action="/search" class="search-form">
						<input type="submit" class="icon search-submit">
						<input type="text" class="search-field" name="q" placeholder="Search">
					</form>
				</div>
				<ul class="left-menu menu">
					@if (Auth::check())
						@if (Auth::user()->hasRole('Administrator'))
							<li><a href="{{ URL::route('admin.index') }}">Control Panel</a></li>
						@endif
						
					@else
						<li><a href="{{ URL::route('account.create') }}">Sign up</a></li>
						<li><a href="{{ URL::route('account.login') }}">Login</a></li>
					@endif
					<li><a href="{{ URL::route('page.show', 'about') }}">About</a></li>
				</ul>
				<ul class="minicart menu">
					<li><a href="{{ URL::route('cart.index') }}">Cart</a></li>
					@if (Auth::check())
						<li><a href="{{ URL::route('account.logout') }}">Log out</a></li>
					@else
						@if (!Cart::isEmpty())
							<li class="checkout"><a href="{{ URL::route('order.make') }}">Check out</a></li>
						@endif
					@endif
				</ul>
			</div>
		</div>
		<div class="row lower">
			<div class="col-md-10 col-md-offset-1">
				<div class="logo"><a href="{{ URL::route('home') }}">{{ Config::get('site/general.sitename', 'Favus') }}</a></div>
			</div>
		</div>
	</div>
</header>