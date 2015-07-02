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
		$title         = Input::get('title');
		$description   = Input::get('description');
		$url           = Input::get('url');
		$categoryId    = Input::get('category_id');
		$articleNumber = Input::get('article_number');
		$price         = Input::get('price');
		$oldPrice      = Input::get('old_price');
		$currency      = Input::get('currency');
		$productImages = Input::get('product_images');
		$mainImageId   = Input::get('main_image_id', 0);

		$data = array(

			'title'          => $title,
			'description'    => $description,
			'category_id'    => $categoryId,
			'url'            => $url,
			'price'          => $price,
			'old_price'      => $oldPrice,
			'article_number' => $articleNumber,
			'currency'       => $currency,
			'product_images' => $productImages,
			'main_image_id'  => $mainImageId,

	 	);

	 	try {

			Product::add($data);

		} catch (InvalidDataException $e) {

			$input = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($input)->withErrors($e->getErrors());
		}

		return Redirect::route('admin.products')->with('global', 'Item added');
	}

	public function postEditProduct($id)
	{
		$title         = Input::get('title');
		$description   = Input::get('description');
		$url           = Input::get('url');
		$categoryId    = Input::get('category_id');
		$articleNumber = Input::get('article_number');
		$price         = Input::get('price');
		$oldPrice      = Input::get('old_price');
		$currency      = Input::get('currency');
		$productImages = Input::get('product_images');
		$mainImageId   = Input::get('main_image_id', 0);

		$data = array(

			'title'          => $title,
			'description'    => $description,
			'category_id'    => $categoryId,
			'url'            => $url,
			'price'          => $price,
			'old_price'      => $oldPrice,
			'article_number' => $articleNumber,
			'currency'       => $currency,
			'product_images' => $productImages,
			'main_image_id'  => $mainImageId,

	 	);

	 	try {

			Product::change($id, $data);

		} catch (InvalidDataException $e) {

			$input = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($input)->withErrors($e->getErrors());
		}

		return Redirect::route('admin.products')->with('global', 'Item edited');
	}
}