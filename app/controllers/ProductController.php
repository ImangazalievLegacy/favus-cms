<?php

class ProductController extends BaseController {

	public function getIndex()
	{
		App::abort(404);
	}

	public function getShowProduct($productUrl)
	{
		$product = Product::findByUrl($productUrl);

		if ($product === null)
		{
			App::abort(404);
		}

		return View::make('catalog.product.card')->with('product', $product);
	}
}