<?php

namespace Favus\Api\Exception;

class UnauthorizedException extends ApiException
{
	public function getStatusCode()
	{
		return 401;
	}
}