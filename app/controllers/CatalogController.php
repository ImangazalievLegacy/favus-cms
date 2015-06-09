
<?php

class CatalogController extends BaseController {

	public function getIndex()
	{
		$products = Product::all();

		return View::make('catalog.index')->with('products', $products);
	}

	public function getCategoryIndex($path)
	{
		$category = Category::getByPath($path);

		if ($category == null)
		{
			App::abort(404);
		}
		else
		{
			if ($category->hasChild())
			{
				$subcategories = $category->getSubcategories();

				$categoryIds = array();

				foreach ($subcategories as $subcategory) {
					
					$categoryIds[] = $subcategory->id;

				}

				$products = Product::getByCategory($categoryIds);
			}
			else
			{
				$products = Product::getByCategory($category->id);
			}
		}

		return View::make('catalog.category')->with('products', $products);
	}

	public function postAddCategory()
	{
		$parentId = Input::get('parent_id');

		$parentCategory = Category::find($parentId);

		if ($parentCategory === null)
		{
			return Redirect::back()->with('global', "Category with id $parentId not found")->withInput($data);
		}

		$title = Input::get('title');
		$url = Input::get('url');

		try {

			$parentCategory->addSub($title, $url);

			return Redirect::back()->with('global', 'Category added');

		} catch (InvalidDataException $e) {

			$data = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($data)->withErrors($e->getErrors());
		}
	}

}