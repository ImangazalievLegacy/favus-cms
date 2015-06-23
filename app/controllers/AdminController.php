<?php

class AdminController extends BaseController {

	public function getIndex()
	{
		return View::make('admin.index');
	}

	public function getProducts()
	{
		$products = Product::paginate(10);

		return View::make('admin.products.index')->with('products', $products);
	}

	public function getAddProduct()
	{
		$categories = Category::getAll();
		$currencies = Currency::all();

		$data = array(

			'categories' => $categories,
			'currencies' => $currencies,

		);

		return View::make('admin.products.add')->with($data);
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

	public function getEditProduct($id)
	{
		$product = Product::find($id);

		if ($product === null)
		{
			return Redirect::route('admin.products')->with('global', 'Item not found');
		}

		$categories = Category::getAll();
		$currencies = Currency::all();

		$data = array(

			'categories' => $categories,
			'currencies' => $currencies,
			'product'    => $product,

		);

		return View::make('admin.products.edit')->with($data);
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

		$data = array(

			'title'          => $title,
			'description'    => $description,
			'category_id'    => $categoryId,
			'url'            => $url,
			'price'          => $price,
			'old_price'      => $oldPrice,
			'article_number' => $articleNumber,
			'currency'       => $currency,

	 	);

	 	try {

			Product::change($id, $data);

		} catch (InvalidDataException $e) {

			$input = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($input)->withErrors($e->getErrors());
		}

		return Redirect::route('admin.products')->with('global', 'Item edited');
	}

	public function getCategories()
	{
		$categories = Category::orderBy('position')->paginate(10);

		return View::make('admin.categories.index')->with('categories', $categories);
	}

	public function getAddCategory()
	{
		$categories = Category::getAll();

		$data = array(

			'categories' => $categories,

		);

		return View::make('admin.categories.add')->with($data);
	}

	public function postAddCategory()
	{
		$title    = Input::get('title');
		$url      = Input::get('url');
		$parentId = Input::get('parent_id');

		$data = array(

			'title'     => $title,
			'url'       => $url,
			'parent_id' => $parentId,

	 	);

	 	try {

			Category::add($parentId, $data);

		} catch (InvalidDataException $e) {

			$input = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($input)->withErrors($e->getErrors());
		}

		return Redirect::route('admin.categories')->with('global', 'Item added');
	}

	public function getEditCategory($id)
	{
		$category = Category::find($id);

		if ($category === null)
		{
			return Redirect::route('admin.categories')->with('global', 'Category not found');
		}

		$categories = Category::getAll();

		$data = array(

			'category'   => $category,
			'categories' => $categories,

		);

		return View::make('admin.categories.edit')->with($data);
	}

	public function postEditCategory($id)
	{
		$title    = Input::get('title');
		$url      = Input::get('url');
		$parentId = Input::get('parent_id');

		$data = array(

			'title'     => $title,
			'url'       => $url,
			'parent_id' => $parentId,

	 	);

	 	try {

			Category::change($id, $data);

		} catch (InvalidDataException $e) {

			$input = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($input)->withErrors($e->getErrors());
		}

		return Redirect::route('admin.categories')->with('global', 'Category edited');
	}

	public function getUsers()
	{
		$users = User::orderBy('id')->paginate(10);

		return View::make('admin.users.index')->with('users', $users);
	}

	public function getOrders()
	{
		$orders = Order::orderBy('id')->paginate(10);

		return View::make('admin.orders.index')->with('orders', $orders);
	}
}