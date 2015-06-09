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

	public function postAddProduct()
	{
		$data = Input::all();

		try {
			Product::add($data);

			return Redirect::back()->with('global', 'Product added');

		} catch (InvalidDataException $e) {

			return Redirect::back()->with('global', $e->getMessage())->withInput($data)->withErrors($e->getErrors());
		}
	}

}