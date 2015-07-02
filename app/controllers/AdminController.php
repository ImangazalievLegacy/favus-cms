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

	public function getPages()
	{
		$pages = Page::orderBy('id')->paginate(10);

		return View::make('admin.pages.index')->with('pages', $pages);
	}

	public function getAddPage()
	{
		return View::make('admin.pages.add');
	}

	public function getEditPage($id)
	{
		$page = Page::find($id);

		if ($page === null)
		{
			return Redirect::route('admin.pages')->with('global', 'Page not found');
		}

		return View::make('admin.pages.edit')->with('page', $page);
	}
}