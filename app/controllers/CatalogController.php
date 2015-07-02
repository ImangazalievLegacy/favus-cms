
<?php

class CatalogController extends BaseController {

	public function getIndex()
	{
		$products = Product::paginate(5);

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

		$data = array(
			
			'category' => $category, 
			'products' => $products, 

		);

		return View::make('catalog.category')->with($data);
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

		return Redirect::route('admin.categories')->with('global', 'Category added');
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
}