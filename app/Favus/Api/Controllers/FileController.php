<?php

namespace Favus\Api\Controllers;

use Favus\Api\Exception;
use \Input as Input;
use \Validator as Validator;

class FileController extends BaseController
{
	public function uploadImage()
	{
		if (!Input::hasFile('file'))
		{
			throw new Exception\InvalidDataException('Ошибка при загрузке файлов (файлы не были отправлены)');
		}

		$file  = Input::file('file');

		$data  = array('userfile' => $file);
		$rules = array('userfile' => 'required|mimes:jpg,jpeg,bmp,png|max:10240');

		$validator = Validator::make($data, $rules);

		if ($validator->fails())
		{
			throw new Exception\InvalidDataException('Invalid Data');
		}

		$ext      = $file->getClientOriginalExtension();
		$filename = str_random(24).'.'.$ext; 
		$date = date('Y/m/d');
		$folder   = 'uploads/'.$date;

		try {

			$file->move($folder, $filename);
			
		} catch (Exception $e) {

			throw new Exception\InternalServerErrorException($e->getMessage());
			
		}

		$path = $folder.'/'.$filename;

		return $path;
	}
}