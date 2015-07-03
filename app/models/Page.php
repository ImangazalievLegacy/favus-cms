<?php

use Illuminate\Support\MessageBag;

class Page extends Eloquent {

	protected $table = 'pages';

	protected $fillable = array('title', 'url', 'visible', 'content');

	public static function findByUrl($url)
	{
		return Page::where('url', '=', $url)->where('visible', true)->limit(1)->get()->first();
	}

	public static function validate($data, $exclusion = null)
	{
		$pageIds = Page::lists('id');

		if (is_numeric($exclusion))
		{
			$pageIds = Page::whereNotIn('id', [$exclusion])->lists('id');
		}
		else
		{
			$pageIds = Page::lists('id');
		}

		$pageIds = implode(',', $pageIds);

		$rules = array(

			'title'     => 'required|min:5|max:256',
			'url'       => 'required|min:3|max:512',
			'visible'   => 'required|boolean',
			'content'   => 'required|min:10',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		if (is_numeric($exclusion))
		{
			$count = self::where('url', $data['url'])->whereNotIn('id', [$exclusion])->count();
		}
		else
		{
			$count = self::where('url', $data['url'])->count();
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

	public static function add($data)
	{
		Page::validate($data);

		$page = Page::create(array(
			
			'title'     => $data['title'],
			'url'       => $data['url'],
			'parent_id' => $data['parent_id'],
			'visible'   => $data['visible'],
			'content'   => $data['content'],
			
		));

		return $page;
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

		$page = Page::find($id);

		if ($page === null)
		{
			throw new NotFoundException("Page with id {$id} not found");
		}
		
		return (bool) $page->delete();
	}

	public static function change($id, $data)
	{
		$page = Page::find($id);

		if ($page === null)
		{
			throw new NotFoundException('Page not found');
		}

		if ($page->url == $data['url'])
		{
			Page::validate($data, $id);
		}
		else
		{
			Page::validate($data);
		}

		$updated = $page->update(array(
			
			'title'     => $data['title'],
			'url'       => $data['url'],
			'parent_id' => $data['parent_id'],
			'visible'   => $data['visible'],
			'content'   => $data['content'],
			
		));

		return $updated;
	}

	public function isVisible()
	{
		return (bool) $this->getAttribute('visible');
	}
}
