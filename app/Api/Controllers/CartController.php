<?php

namespace Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;
use \Cart as Cart;

class CartController extends BaseController
{
	public function addProduct()
	{
		$id = Input::get('id');

		try {

			Cart::add($id);

		} catch (\Favus\Cart\Exception\InvalidDataException $e) {

			throw new Exception\InvalidDataException($e->getMessage());

		} catch (\Favus\Cart\Exception\NotFoundException $e) {

			throw new Exception\NotFoundException($e->getMessage());
		}
	}

	public function deleteProduct()
	{
		$data = Input::all();

		$id = Input::get('id');

		Cart::delete($id);
	}
}