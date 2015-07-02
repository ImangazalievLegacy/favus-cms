<?php

use Favus\Api\Facades\Router as Router;

Router::group(array('prefix' => 'cart'), function() {

	Router::any('add', 'CartController@addProduct');
	Router::any('delete', 'CartController@deleteProduct');
	
});

Router::group(array('prefix' => 'product'), function() {

	Router::any('delete', 'ProductController@deleteProduct');

});

Router::group(array('prefix' => 'category'), function() {

	Router::any('delete', 'CatalogController@deleteCategory');

});

Router::group(array('prefix' => 'files'), function() {

	Router::any('images/upload', 'FileController@uploadImage');

});

Router::group(array('prefix' => 'user'), function() {

	Router::any('delete', 'UserController@deleteUser');

});

Router::group(array('prefix' => 'order'), function() {

	Router::any('delete', 'OrderController@deleteOrder');

});

Router::group(array('prefix' => 'page'), function() {

	Router::any('delete', 'PageController@deletePage');

});