<?php

namespace Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;
use \Order as Order;
use \NotFoundException as NotFoundException;
use \InvalidDataException as InvalidDataException;

class OrderController extends BaseController
{
	public function deleteOrder()
	{
		$id = Input::get('id');

		try {

			$result = Order::destroy($id);

		} catch (NotFoundException $e) {

			throw new Exception\NotFoundException($e->getMessage());
			
		} catch (InvalidDataException $e) {

			throw new Exception\InvalidDataException($e->getMessage());
		}

		return $result;
	}
}