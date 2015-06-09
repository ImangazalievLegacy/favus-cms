<?php

namespace Favus\Api\Exception;

class InternalServerErrorException extends ApiException
{
	public function getStatusCode()
	{
		return 500;
	}
}