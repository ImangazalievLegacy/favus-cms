<?php

namespace Shop\Api\Exception;

class NotFoundException extends ApiException
{
	public function getStatusCode()
	{
		return 404;
	}
}