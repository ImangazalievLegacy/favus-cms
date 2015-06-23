<?php

namespace Favus\Cart;

use \Validator as Validator;
use \Session as Session;

class Cart {

	protected $sessionKey = 'cart.items';

	public function all()
	{
		$products = [];

		if (Session::has($this->sessionKey))
		{
			foreach (Session::get($this->sessionKey) as $product) 
			{	
				$products[] = unserialize($product);
			}
		}

		return $products;
	}

	public static function validate($data)
	{
		$rules = array(

			'id' => 'required|numeric',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new Exception\InvalidDataException('Invalid Data', $validator->errors());
		}
	}

	public function add($id, $count = 1)
	{
		$data = ['id' => $id];

		Cart::validate($data);
		
		$product = \Product::find($id);

		if ($product === null) 
		{
			throw new Exception\NotFoundException('Not Found');
		}

		$data = $product->toArray();

		$product = new \Favus\Product\Product($data);

		$product->count = $count;

		if (!\Cart::has($product->id))
		{
			$key = $this->sessionKey . '.' . $product->id;

			$data = serialize($product);

			Session::put($key, $data);
		}
	}

	public function delete($id)
	{
		$data = ['id' => $id];

		Cart::validate($data);
		
		Session::forget($this->sessionKey . '.' . $id);
	}

	public function clear()
	{
		Session::forget($this->sessionKey);
	}

	public function has($id)
	{
		return Session::has($this->sessionKey . '.' . $id);
	}

	public function count()
	{
		return count($this->all());
	}

	public function isEmpty()
	{
		return $this->count() == 0;
	}

	public function getTotal()
	{
		$total = 0;

		$products = $this->all();

		foreach ($products as $product) 
		{	
			$total += $product->getPrice();
		}

		return $total;
	}

}