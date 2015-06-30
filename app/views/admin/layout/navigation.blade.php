<div class="navbar-s collapse navbar-collapse navbar-ex1-collapse" style=" background-color: #313541; ">
	<ul class="nav navbar-nav side-nav">
		<li class="{{ Route::is('admin.index') ? 'active' : '' }}">
			<a href="{{ URL::route('admin.index') }}"><i class="fa fa-fw fa-dashboard"></i> Главная</a>
		</li>
		<li class="{{ Route::is('admin.products*') ? 'active' : '' }}">
			<a href="{{ URL::route('admin.products') }}"><i class="fa fa-fw fa-cubes"></i> Товары</a>
		</li>
		<li class="{{ Route::is('admin.categories*') ? 'active' : '' }}">
			<a href="{{ URL::route('admin.categories') }}"><i class="fa fa-fw fa-tasks"></i> Категории</a>
		</li>
		<li class="{{ Route::is('admin.orders*') ? 'active' : '' }}">
			<a href="{{ URL::route('admin.orders') }}"><i class="fa fa-fw fa-shopping-cart"></i> Заказы</a>
		</li>
		<li class="{{ Route::is('admin.users*') ? 'active' : '' }}">
			<a href="{{ URL::route('admin.users') }}"><i class="fa fa-fw fa-user"></i> Пользователи</a>
		</li>
	</ul>
</div>