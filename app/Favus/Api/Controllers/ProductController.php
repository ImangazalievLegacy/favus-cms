<?php

namespace Favus\Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;
use \Product as Product;

class ProductController extends BaseController
{
	public function deleteProduct()
	{
		$data = Input::all();

		$rules = array(

			'id' => 'required|numeric',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new Exception\InvalidDataException();
		}

		$id = Input::get('id');

		return Product::destroy($id);
	}
}


