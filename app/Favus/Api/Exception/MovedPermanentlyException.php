<?php

namespace Shop\Api\Exception;

class MovedPermanentlyException extends ApiException
{
	public function getStatusCode()
	{
		return 301;
	}
}