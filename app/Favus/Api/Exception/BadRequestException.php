<?php

namespace Favus\Api\Exception;

class BadRequestException extends ApiException
{
	public function getStatusCode()
	{
		return 400;
	}
}