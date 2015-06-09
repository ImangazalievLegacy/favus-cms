<?php

/*
* Паттерны параметров роутов
*/
Route::pattern('id', '[0-9]+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('string', '[a-zA-Z0-9]+');
Route::pattern('username', '[a-f0-9]+');

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

			'as' => 'account.create',
			'uses' => 'AccountController@getCreate'

		));

		Route::get('login', array(

			'as' => 'account.login',
			'uses' => 'AccountController@getLogin'

		));

		Route::get('activate/{code}', array(

			'as' => 'account.activate',
			'uses' => 'AccountController@getActivate'

		))->where('code', '[a-zA-Z0-9]+');

		Route::get('forgot-password', array(

			'as' => 'account.forgot.password',
			'uses' => 'AccountController@getForgotPassword'

		));

		Route::get('password/reset/{code}', array(

			'as' => 'account.password.reset',
			'uses' => 'AccountController@getResetPassword'

		));

		Route::get('resend-activation-code', array(

			'as' => 'resend.activation.code',
			'uses' => 'AccountController@getResendCode'

		));


		Route::group(array('before' => 'csrf'), function(){

			Route::post('create', array(

				'as' => 'account.create-post',
				'uses' => 'AccountController@postCreate'

			));

			Route::post('login', array(

				'as' => 'account.login-post',
				'uses' => 'AccountController@postLogin'

			));

			Route::post('forgot-password', array(

				'as' => 'account.forgot.password-post',
				'uses' => 'AccountController@postForgotPassword'

			));

			Route::post('password/reset', array(

				'as' => 'account.password.reset-post',
				'uses' => 'AccountController@postResetPassword'

			));

			Route::post('resend-activation-code', array(

				'as' => 'resend.activation.code-post',
				'uses' => 'AccountController@postResendCode'

			));

		});

	});

	/*
	* Для авторизованных пользователей
	*/

	Route::group(array('before' => 'auth'), function(){

		Route::get('logout', array(

			'as' => 'account.logout',
			'uses' => 'AccountController@getLogOut'

		));

	});

});

Route::group(array('prefix' => 'catalog'), function()
{

	Route::get('/', array(

		'as' => 'catalog.index',
		'uses' => 'CatalogController@getIndex'

	));

	Route::get('/{path}', array(

		'as' => 'catalog.category',
		'uses' => 'CatalogController@getCategoryIndex'

	))->where('path', '.*');

});

Route::group(array('prefix' => 'item'), function()
{

	Route::get('/', array(

		'as' => 'products.index',
		'uses' => 'ProductController@getIndex'

	));

	Route::get('/{url}', array(

		'as' => 'product.show',
		'uses' => 'ProductController@getShowProduct'

	));

});

Route::group(array('prefix' => 'cart'), function()
{

	Route::get('/', array(

		'as' => 'cart.index',
		'uses' => 'CartController@getIndex'

	));

});

Route::group(array('prefix' => 'api'), function()
{
	Route::any('/{path}', 'ApiController@callMethod')->where('path', '.*');
});