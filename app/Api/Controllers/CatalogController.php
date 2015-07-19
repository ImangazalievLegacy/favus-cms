<?php

namespace Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;
use \Category as Category;
use \NotFoundException as NotFoundException;
use \InvalidDataException as InvalidDataException;

class CatalogController extends BaseController
{
	public function deleteCategory()
	{
		$id = Input::get('id');

		try {

			$affectedRows = Category::destroy($id);

		} catch (NotFoundException $e) {

			throw new Exception\NotFoundException($e->getMessage());
			
		} catch (InvalidDataException $e) {

			throw new Exception\InvalidDataException($e->getMessage());
		}
	}
}