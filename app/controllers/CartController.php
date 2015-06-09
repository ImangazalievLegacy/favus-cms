<?php

class CartController extends BaseController
{
	public function getIndex()
	{
		$items = Cart::all();
		$total = Cart::getTotal();

		$data = array(

			'items' => $items,
			'total' => $total,

		);

		return View::make('cart.index')->with($data);
	}
}


