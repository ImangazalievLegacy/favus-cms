<?php

namespace Favus\Cart;

use \Validator as Validator;
use \Session as Session;
use \Config as Config;

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

	public function add($id, $quantity = 1)
	{
		$data = ['id' => $id];

		Cart::validate($data);
		
		$product = \Product::find($id);

		if (($product === null) or (!$product->isVisible())) 
		{
			throw new Exception\NotFoundException('Not Found');
		}

		$data = $product->toArray();

		$product = new \Favus\Product\Product($data);

		if (\Cart::has($product->id))
		{
			$totalQuantity = ($quantity + \Cart::get($product->id)->quantity);

			$quantity = (($product->count != -1) and ($totalQuantity > $product->count)) ? $product->count : $totalQuantity;
		}
		else
		{
			$quantity = (($product->count != -1) and ($quantity > $product->count)) ? $product->count : $quantity;
		}

		$product->setQuantity($quantity);

		$key = $this->sessionKey . '.' . $product->id;

		$data = serialize($product);

		Session::put($key, $data);
	}

	public function get($id)
	{
		$data = ['id' => $id];

		Cart::validate($data);

		if (!\Cart::has($id))
		{
			throw new Exception\NotFoundException('Not Found');
		}

		$key = $this->sessionKey . '.' . $id;

		$data = Session::get($key);

		$product = unserialize($data);

		return $product;
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

	public function getTotal($withDiscount = true)
	{
		$total = 0;

		$products = $this->all();

		foreach ($products as $product) 
		{	
			$total += $product->getTotal();
		}

		if (Config::get('site/order.discount.enabled') and $withDiscount)
		{
			if ($total >= Config::get('site/order.discount.from'))
			{
				$discount = Config::get('site/order.discount.percentage');

				$total = (int) ($total - ($total/100) * $discount);
			}
		}

		return $total;
	}

}