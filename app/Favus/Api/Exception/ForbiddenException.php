<?php

namespace Shop\Api\Exception;

class ForbiddenException extends ApiException
{
	public function getStatusCode()
	{
		return 403;
	}
}