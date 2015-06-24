<nav>

	<h3>Навигация</h3>

	<ul>
		<li><a href="{{ URL::route('home') }}">Home</a></li>
		<li><a href="{{ URL::route('cart.index') }}">Cart</a></li>

		@if (Auth::check())

			@if (Auth::user()->hasRole('Administrator'))
			
				<li><a href="{{ URL::route('admin.index') }}">Control Panel</a></li>
			
			@endif

			<li><a href="{{ URL::route('account.logout') }}">Log Out</a></li>

		@else

			<li><a href="{{ URL::route('account.login') }}">Log In</a></li>
			<li><a href="{{ URL::route('account.create') }}">Create an account</a></li>
			<li><a href="{{ URL::route('resend.activation.code') }}">Resend Activation Code</a></li>
		
		@endif

	</ul>

	<h3>Категории</h3>

	@include('layout.categories')
</nav>