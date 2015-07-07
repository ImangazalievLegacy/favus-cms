<?php

/*
* Паттерны параметров роутов
*/
Route::pattern('id', '[0-9]+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('string', '[a-zA-Z0-9]+');
Route::pattern('username', '[a-f0-9]+');

Route::when('*', 'opened', ['get', 'post', 'put', 'patch', 'delete']);

Route::get('/downtime', array(

	'as' => 'downtime',
	'uses' => 'HomeController@downtime'

));

Route::get('/', array(

	'as' => 'home',
	'uses' => 'HomeController@home'

));

Route::group(array('prefix' => 'account'), function()
{

	/*
	* Для неавторизованных пользователей
	*/
	
	Route::group(array('before' => 'guest'), function(){

		Route::get('create', array(

			'as'   => 'account.create',
			'uses' => 'AccountController@getCreate'

		));

		Route::get('login', array(

			'as'   => 'account.login',
			'uses' => 'AccountController@getLogin'

		));

		Route::get('activate/{code}', array(

			'as'   => 'account.activate',
			'uses' => 'AccountController@getActivate'

		))->where('code', '[a-zA-Z0-9]+');

		Route::get('forgot-password', array(

			'as'   => 'account.forgot.password',
			'uses' => 'AccountController@getForgotPassword'

		));

		Route::get('password/reset/{code}', array(

			'as'   => 'account.password.reset',
			'uses' => 'AccountController@getResetPassword'

		));

		Route::get('resend-activation-code', array(

			'as'   => 'resend.activation.code',
			'uses' => 'AccountController@getResendCode'

		));


		Route::group(array('before' => 'csrf'), function(){

			Route::post('create', array(

				'as'   => 'account.create-post',
				'uses' => 'AccountController@postCreate'

			));

			Route::post('login', array(

				'as'   => 'account.login-post',
				'uses' => 'AccountController@postLogin'

			));

			Route::post('forgot-password', array(

				'as'   => 'account.forgot.password-post',
				'uses' => 'AccountController@postForgotPassword'

			));

			Route::post('password/reset', array(

				'as'   => 'account.password.reset-post',
				'uses' => 'AccountController@postResetPassword'

			));

			Route::post('resend-activation-code', array(

				'as'   => 'resend.activation.code-post',
				'uses' => 'AccountController@postResendCode'

			));

		});

	});

	/*
	* Для авторизованных пользователей
	*/

	Route::group(array('before' => 'auth'), function(){

		Route::get('logout', array(

			'as'   => 'account.logout',
			'uses' => 'AccountController@getLogOut'

		));

	});

});

Route::group(array('prefix' => 'catalog'), function()
{

	Route::get('/', array(

		'as'   => 'catalog.index',
		'uses' => 'CatalogController@getIndex'

	));

	Route::get('/{path}', array(

		'as'   => 'catalog.category',
		'uses' => 'CatalogController@getCategoryIndex'

	))->where('path', '.*');

});

Route::group(array('prefix' => 'item'), function()
{

	Route::get('/', array(

		'as'   => 'products.index',
		'uses' => 'ProductController@getIndex'

	));

	Route::get('/{url}', array(

		'as'   => 'product.show',
		'uses' => 'ProductController@getShowProduct'

	));

});

Route::group(array('prefix' => 'cart'), function()
{

	Route::get('/', array(

		'as'   => 'cart.index',
		'uses' => 'CartController@getIndex'

	));

});

Route::group(array('prefix' => 'order'), function()
{
	Route::get('/', array(

		'as'   => 'order.make',
		'uses' => 'OrderController@getMakeOrder'

	));

	Route::group(array('before' => 'csrf'), function(){

		Route::post('make', array(

			'as'   => 'order.make-post',
			'uses' => 'OrderController@postMakeOrder'

		));
	});
});

Route::group(array('prefix' => 'api'), function()
{
	Route::any('/{path}', array(

		'as'   => 'api.call-method',
		'uses' => 'ApiController@callMethod'

	))->where('path', '.*');
});

Entrust::routeNeedsRole('admin*', 'Administrator');

Route::group(array('prefix' => 'admin'), function()
{

	Route::get('/', array(

		'as'   => 'admin.index',
		'uses' => 'AdminController@getIndex'

	));

	Route::group(array('prefix' => 'categories'), function()
	{
		Route::get('/', array(

			'as'   => 'admin.categories',
			'uses' => 'AdminController@getCategories'

		));

		Route::get('/add', array(

			'as'   => 'admin.categories.add',
			'uses' => 'AdminController@getAddCategory'

		));

		Route::get('/edit/{id}', array(

			'as'   => 'admin.categories.edit',
			'uses' => 'AdminController@getEditCategory'

		));

		Route::group(array('before' => 'csrf'), function(){

			Route::post('/add', array(

				'as'   => 'admin.categories.add-post',
				'uses' => 'CatalogController@postAddCategory'

			));

			Route::post('/edit/{id}', array(

				'as'   => 'admin.categories.edit-post',
				'uses' => 'CatalogController@postEditCategory'

			));
		});
	});

	Route::group(array('prefix' => 'products'), function()
	{
		Route::get('/', array(

			'as'   => 'admin.products',
			'uses' => 'AdminController@getProducts'

		));

		Route::get('/add', array(

			'as'   => 'admin.products.add',
			'uses' => 'AdminController@getAddProduct'

		));

		Route::get('/edit/{id}', array(

			'as'   => 'admin.products.edit',
			'uses' => 'AdminController@getEditProduct'

		));

		Route::group(array('before' => 'csrf'), function(){

			Route::post('/add', array(

				'as'   => 'admin.products.add-post',
				'uses' => 'ProductController@postAddProduct'

			));

			Route::post('/edit/{id}', array(

				'as'   => 'admin.products.edit-post',
				'uses' => 'ProductController@postEditProduct'

			));
		});
	});

	Route::group(array('prefix' => 'users'), function()
	{
		Route::get('/', array(

			'as'   => 'admin.users',
			'uses' => 'AdminController@getUsers'

		));
	});

	Route::group(array('prefix' => 'orders'), function()
	{

		Route::get('/', array(

			'as'   => 'admin.orders',
			'uses' => 'AdminController@getOrders'

		));
	});

	Route::group(array('prefix' => 'pages'), function()
	{
		Route::get('/', array(

			'as'   => 'admin.pages',
			'uses' => 'AdminController@getPages'

		));

		Route::get('/add', array(

			'as'   => 'admin.pages.add',
			'uses' => 'AdminController@getAddPage'

		));

		Route::get('/edit/{id}', array(

			'as'   => 'admin.pages.edit',
			'uses' => 'AdminController@getEditPage'

		));

		Route::group(array('before' => 'csrf'), function(){

			Route::post('/add', array(

				'as'   => 'admin.pages.add-post',
				'uses' => 'PageController@postAddPage'

			));

			Route::post('/edit/{id}', array(

				'as'   => 'admin.pages.edit-post',
				'uses' => 'PageController@postEditPage'

			));
		});
	});
});

Route::group(array('prefix' => 'install'), function()
{
	Route::get('/', 'Installer@run');
});

Route::group(array('prefix' => 'pages'), function()
{

	Route::get('/{url}', array(

		'as'   => 'page.show',
		'uses' => 'PageController@getShowPage'

	))->where('path', '.*');

});