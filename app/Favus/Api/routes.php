<?php

use Favus\Api\Facades\Router as Router;

Router::group(array('prefix' => 'cart'), function() {

	Router::any('add', 'CartController@addProduct');
	Router::any('delete', 'CartController@deleteProduct');
	
});

Router::group(array('prefix' => 'product'), function() {

	Router::any('delete', 'ProductController@deleteProduct');

});