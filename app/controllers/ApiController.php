<?php

class ApiController extends BaseController {

	public function callMethod($path, $responseType =  'json')
	{
		$api = new Favus\Api\ApiDispatcher();

		return $api->handle($path, $responseType);
	}

}
