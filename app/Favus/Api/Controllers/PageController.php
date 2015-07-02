<?php

namespace Favus\Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;
use \Page as Page;
use \NotFoundException as NotFoundException;
use \InvalidDataException as InvalidDataException;

class PageController extends BaseController
{
	public function deletePage()
	{
		$id = Input::get('id');

		try {

			$result = Page::destroy($id);

		} catch (NotFoundException $e) {

			throw new Exception\NotFoundException($e->getMessage());
			
		} catch (InvalidDataException $e) {

			throw new Exception\InvalidDataException($e->getMessage());
		}

		return $result;
	}
}