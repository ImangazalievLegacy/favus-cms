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

		Category::clearCache();

		return parent::addChild($data);
	}

	public static function add($parentId, $data)
	{
		$category = Category::find($parentId);

		if ($category === null)
		{
			throw new NotFoundException("Category with id {$parentId} not found");
		}
		
		return $category->addSub($data['title'], $data['url']);
	}

	public function deleteNode()
	{
		Category::clearCache();

		return parent::deleteNode();
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

		foreach ($categories as $category)
		{
			if ($category->getPath() == $path)
			{
				return $category;
			}
		}

		return null;
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
			$errors = new MessageBag();

			$message = Lang::get('validation.unique');
			$message = str_replace(':attribute', 'URL', $message);

			$errors->add('url', $message);

			throw new InvalidDataException('Invalid Data', $errors);
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

		if ($updated)
		{
			Category::clearCache();
		}

		return $updated;
	}

	public function getWidth()
	{
		$key = "categories.{$this->id}.width";

		if (Cache::has($key))
		{
			return Cache::get($key);
		}

		$width = parent::getWidth();

		Cache::forever($key, $width);

		return $width;
	}

	public function getPath()
	{
		$key = "categories.{$this->id}.path";

		if (Cache::has($key))
		{
			return Cache::get($key);
		}

		Category::cache(); 

		return Cache::get($key);
	}

	public function getBreadcrumbs()
	{
		$key = "categories.{$this->id}.breadcrumbs";

		if (Cache::has($key))
		{
			return Cache::get($key);
		}

		Category::cache(); 

		return Cache::get($key);
	}

	public function cache($clearCache = true)
	{
		if ($clearCache)
		{
			Category::clearCache();
		}

		$categories = Category::getAll();

		$lastLevel = 0;

		$path = array();
		$breadcrumbs = array();

		foreach ($categories as $category)
		{
			if ($category->level > 0) 
			{
				if ($category->level <= $lastLevel)
				{
					$diff = $lastLevel - $category->level + 1;

					$newSize = count($path) - $diff;

					$path = array_slice($path, 0, $newSize);
					$breadcrumbs = array_slice($breadcrumbs, 0, $newSize);
				}
				
				$path[] = $category->url;
				$breadcrumbs[] = $category->title;
			}

			$lastLevel = $category->level;

			$pathKey = "categories.{$category->id}.path";
			$breadcrumbsKey = "categories.{$category->id}.breadcrumbs";

			Cache::forever($pathKey, implode('/', $path)); 
			Cache::forever($breadcrumbsKey, $breadcrumbs); 
		}
	}

	public static function clearCache()
	{
		Cache::forget('categories');
	}

}
