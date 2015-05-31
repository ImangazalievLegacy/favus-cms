<?php

use Illuminate\Support\MessageBag as MessageBag;

class InvalidDataException extends \Exception
{

	/**
	 * @var \Illuminate\Support\MessageBug
	 */
	protected $errors;
	
	/**
	 * @param string $message
	 * @param \Illuminate\Support\MessageBug $errors
	 * @return void
	 */
	function __construct($message, MessageBag $errors)
	{
		$this->errors = $errors;

		parent::__construct($message);
	}

	/**
	 * @return \Illuminate\Support\MessageBug
	 */
	public function getErrors()
	{
	    return $this->errors;
	}
}