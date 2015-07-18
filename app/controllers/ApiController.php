<?php

class ApiController extends BaseController {

	public function callMethod($path, $responseType =  'json')
	{
		$api = new Favus\Api\Dispatcher();

		return $api->handle($path, $responseType);
	}

}
