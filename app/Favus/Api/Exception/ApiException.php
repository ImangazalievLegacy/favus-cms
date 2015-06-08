<?php

namespace Shop\Api\Exception;

abstract class ApiException extends \Exception
{
	protected $message;
	protected $description;
	
	function __construct($message, $description = null)
	{
		$this->setDescription($description);

		parent::__construct($message, $this->getStatusCode());
	}

	public function getDescription()
	{
	    return $this->description;
	}
	
	public function setDescription($description)
	{
	    $this->description = $description;
	    
	    return $this;
	}

	abstract public function getStatusCode();
}