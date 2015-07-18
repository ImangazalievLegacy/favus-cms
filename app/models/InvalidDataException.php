<?php

use Illuminate\Support\MessageBag as MessageBag;

class InvalidDataException extends \Exception {

	/**
	 * @var \Illuminate\Support\MessageBag
	 */
	protected $errors;
	
	/**
	 * @param string $message
	 * @param \Illuminate\Support\MessageBag $errors
	 * @return void
	 */
	function __construct($message, $errors = null)
	{
		if ($errors instanceof MessageBag)
		{
			$this->errors = $errors;
		}

		parent::__construct($message);
	}

	/**
	 * @return \Illuminate\Support\MessageBag
	 */
	public function getErrors()
	{
	    return $this->errors;
	}
}