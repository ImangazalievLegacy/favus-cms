<?php

class Category extends Tree {

	protected $table = 'categories';

	protected $fillable = array('title', 'parent_id', 'level', 'position');

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
		$rules = array(

			'title'     => 'required|max:256|min:3',
			'url'       => 'required|max:512|min:2|unique:categories',
			'parent_id' => 'required',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		return parent::addChild($data);
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

}
