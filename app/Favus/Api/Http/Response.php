<?php

namespace Favus\Api\Http;

use Exception\ApiException as Exception;

class Response extends \Illuminate\Http\Response {

	protected $data;
	protected $isRaw;

	public function __construct($data = null, $code = 200, $isRaw = false)
	{
		parent::__construct();

		$this->setStatusCode($code);
		$this->setData($data);
		$this->isRaw($isRaw);
	}

	public function isRaw($isRaw = null)
	{
		if ($isRaw === null)
		{
			return $this->isRaw;
		}
		else
		{
			$this->isRaw = (bool) $isRaw;
		}
	}

	public function getData()
	{
	    return $this->data;
	}
	
	public function setData($data)
	{
	    $this->data = $data;
	    
	    return $this;
	}

	public static function error($code, $message, $description = null)
	{
		$data = ['error' => ['message' => $message]];

		if ($description !== null)
		{
			$data['error']['description'] = $description;
		}

		$response = new static($data, $code, true);

		return $response;
	}

	public function toArray()
	{
		$array = ['status' => $this->getStatusCode()];	

		$data = $this->getData();	

		if ($this->isRaw() and is_array($data))
		{
			$array = array_merge($array, $data);
		}
		else
		{
			$array['response'] = $data;
		}

		return $array;
	}

	public function toString()
	{
		return json_encode($this->toArray());
	}

	public function send()
	{
		$content = $this->toString();

		$this->setContent($content);

		parent::send();
	}
}