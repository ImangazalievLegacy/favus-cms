<?php

$router->group(array('prefix' => 'cart'), function() use ($router)
{
	$router->any('add', 'CartController@addProduct');
	$router->any('delete', 'CartController@deleteProduct');
});