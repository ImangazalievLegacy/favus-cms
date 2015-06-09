<?php

namespace Favus\Product;

class Product {

	protected $title;
	protected $description;
	protected $articleNumber;

	protected $price;
	protected $oldPrice;
	protected $currency;

	protected $categoryId;

	protected $attributes = array();

	public function __construct($data = array())
	{
		$this->fromArray($data);
	}

	public function fromArray(array $array)
	{

		foreach ($array as $name => $value) {
			// normalize key
			switch (strtolower(str_replace(array('.', '-', '_'), '', $name))) {
				case 'title':
					$this->setTitle($value);
					break;
				case 'description':
					$this->setDescription($value);
					break;
				case 'articlenumber':
					$this->setArticleNumber($value);
					break;
				case 'categoryid':
					$this->setCategoryId($value);
					break;
				case 'price':
					$this->setPrice($value);
					break;
				case 'oldprice':
					$this->setOldPrice($value);
					break;
				case 'currency':
					$this->setCurrency($value);
					break;
				default:
					$this->setAttribute($name, $value);
					break;
			}
		}

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
		
		return $this;
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

	public function getPrice()
	{
		return $this->price;
	}
	
	public function setPrice($price)
	{
		$this->price = $price;
		
		return $this;
	}

	public function getOldPrice()
	{
		return $this->oldPrice;
	}
	
	public function setOldPrice($oldPrice)
	{
		$this->oldPrice = $oldPrice;
		
		return $this;
	}

	public function getCategoryId()
	{
		return $this->categoryId;
	}
	
	public function setCategoryId($categoryId)
	{
		$this->categoryId = $categoryId;
		
		return $this;
	}

	public function getCurrency()
	{
		return $this->currency;
	}
	
	public function setCurrency($currency)
	{
		$this->currency = $currency;
		
		return $this;
	}

	public function getArticleNumber()
	{
		return $this->articleNumber;
	}
	
	public function setArticleNumber($articleNumber)
	{
		$this->articleNumber = $articleNumber;
		
		return $this;
	}

	public function getAttribute($name)
	{
		if (array_key_exists($name, $this->attributes))
		{
			 return $this->attributes[$name];
		}

		return null;
	}
	
	public function setAttribute($name, $value)
	{
		$this->attributes[$name] = $value;
		
		return $this;
	}

	public function __sleep()
	{
		return array('title', 'description', 'articleNumber', 'categoryId', 'price', 'oldPrice', 'currency', 'attributes');
	}

	public function __set($name, $value) 
	{
		if (property_exists($this, $name))
		{
			return $this->$name = $value;
		}

		$this->setAttribute($name, $value);
	}

	public function __get($name) 
	{
		if (property_exists($this, $name))
		{
			return $this->$name;
		}

		return $this->getAttribute($name);
	}

	public function __isset($name) 
	{
		return array_key_exists($name, $this->attributes);
	}

	public function __unset($name) 
	{
		unset($this->attributes[$name]);
	}

	public function __call($name, $parameters) 
	{
		if (starts_with($name, 'set') and (count($parameters) > 0))
		{
			$name = substr($name, 2);
			$this->setAttribute(lcfirst($name), $parameters[0]);
		}

		if (starts_with($name, 'get'))
		{
			$name = substr($name, 2);
			$this->getAttribute(lcfirst($name));
		}
	}

}