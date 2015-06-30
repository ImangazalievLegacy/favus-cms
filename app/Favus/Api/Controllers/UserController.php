<?php

namespace Favus\Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;
use \User as User;
use \NotFoundException as NotFoundException;
use \InvalidDataException as InvalidDataException;

class UserController extends BaseController
{
	public function deleteUser()
	{
		$id = Input::get('id');

		try {

			$result = User::destroy($id);

		} catch (NotFoundException $e) {

			throw new Exception\NotFoundException($e->getMessage());
			
		} catch (InvalidDataException $e) {

			throw new Exception\InvalidDataException($e->getMessage());
		}

		return $result;
	}
}