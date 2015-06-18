<?php

use Illuminate\Support\MessageBag;

class Category extends Tree {

	protected $table = 'categories';

	protected $fillable = array('title', 'url', 'parent_id', 'level', 'position');

	public static function getAll()
	{
		return Category::allNodes();
	}

	public static function createRoot($title, $truncate = true)
	{
		$data = ['title' => $title];

		return parent::createRoot($data, $truncate);
	}

	public function addSub($title, $url)
	{
		return $this->addChild(['title' => $title, 'url' => $url, 'parent_id' => $this->id]);
	}

	public function addChild($data)
	{
		Category::validate($data);

		return parent::addChild($data);
	}

	public static function add($parentId, $data)
	{
		Category::validate($data);

		$category = Category::find($parentId);

		if ($category === null)
		{
			throw new NotFoundException("Category with id {$parentId} not found");
		}
		
		return $category->addSub($data['title'], $data['url']);
	}

	public static function destroy($id)
	{
		$data = ['id' => $id];

		$rules = array(

			'id' => 'required|numeric',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid ID', $validator->errors());
		}

		$category = self::find($id);

		if ($category === null)
		{
			throw new NotFoundException("Category with id {$id} not found");
		}

		return (bool) $category->deleteNode();
	}

	public static function getByPath($path, $delimiter = '/')
	{	
		$categories = Category::getAll();

		$segments = explode($delimiter, $path);

		$level = 0;

		$result = null;

		$categoriesNum = count($categories);

		for ($i=1; $i < $categoriesNum; $i++) { 

		 	$category = $categories[$i];

			if ($category->level == $level+1)
			{
				if ($category->url == $segments[$level])
				{
					$level++;

					if ($category->level == count($segments))
					{
						$result = $category;
						break;
					}
				}
			}
		}

		return $result;
	}

	public function getSubcategories()
	{
		return $this->childNodes();
	}

	public function addSubcategory($title, $url)
	{
		$params = array('title' => $title, 'url' => $url);

		return $this->addChild($params);
	}

	public static function validate($data, $exclusion = null)
	{
		$categoryIds = Category::lists('id');
		$categoryIds = implode(',', $categoryIds);

		$rules = array(

			'title'     => 'required|min:2|max:256',
			'url'       => 'required|min:2|max:512',
			'parent_id' => 'required|in:' . $categoryIds,

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		if (is_numeric($exclusion))
		{
			$count = self::where('parent_id', $data['parent_id'])->where('url', $data['url'])->whereNotIn('id', [$exclusion])->count();
		}
		else
		{
			$count = self::where('parent_id', $data['parent_id'])->where('url', $data['url'])->count();
		}		

		if ($count > 0)
		{
			$error = new MessageBag();

			$message = Lang::get('validation.unique');
			$message = str_replace(':attribute', 'URL', $message);

			$error->add('url', $message);

			throw new InvalidDataException('Invalid Data', $error);
		}
	}

	public static function change($id, $data)
	{
		$category = Category::find($id);

		if ($category === null)
		{
			throw new NotFoundException('Category not found');
		}

		if ($category->url == $data['url'])
		{
			Category::validate($data, $id);
		}
		else
		{
			Category::validate($data);
		}

		if (($category->parent_id != $data['parent_id']))
		{
			$category->move($data['parent_id']);
		}

		$updated = $category->update(array(
			
			'title'     => $data['title'],
			'url'       => $data['url'],
			
		));

		return $updated;
	}

}
