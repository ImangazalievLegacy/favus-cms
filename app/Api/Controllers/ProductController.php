<?php

namespace Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;
use \Product as Product;
use \NotFoundException as NotFoundException;
use \InvalidDataException as InvalidDataException;

class ProductController extends BaseController
{
	public function deleteProduct()
	{
		$id = Input::get('id');

		try {

			$result = Product::destroy($id);

		} catch (NotFoundException $e) {

			throw new Exception\NotFoundException($e->getMessage());
			
		} catch (InvalidDataException $e) {

			throw new Exception\InvalidDataException($e->getMessage());
		}

		return $result;
	}
}