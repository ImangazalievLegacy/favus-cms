<nav>

	<h3>Навигация</h3>

	<ul>
		<li><a href="{{ URL::route('admin.index') }}">Index page</a></li>
		<li><a href="{{ URL::route('home') }}">Site</a></li>
		
		<li><a href="{{ URL::route('admin.products') }}">Товары</a></li>
		<li><a href="{{ URL::route('admin.categories') }}">Категории</a></li>
		<li><a href="{{ URL::route('admin.orders') }}">Заказы</a></li>
		<li><a href="{{ URL::route('admin.users') }}">Пользователи</a></li>
	</ul>

</nav>