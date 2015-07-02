<?php

class PageController extends BaseController {

	public function getShowPage($pageUrl)
	{
		$page = Page::findByUrl($pageUrl);

		if (($page === null) or (!$page->isVisible()))
		{
			App::abort(404);
		}

		return View::make('pages.page')->with('page', $page);
	}

	public function postAddPage()
	{
		$title    = Input::get('title');
		$url      = Input::get('url');
		$parentId = Input::get('parent_id');
		$visible  = Input::get('visible', false);
		$content  = Input::get('content');

		$data = array(

			'title'     => $title,
			'url'       => $url,
			'parent_id' => $parentId,
			'visible'   => $visible,
			'content'   => $content,

	 	);

	 	try {

			Page::add($data);

		} catch (InvalidDataException $e) {

			$input = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($input)->withErrors($e->getErrors());
		}

		return Redirect::route('admin.pages')->with('global', 'Page added');
	}

	public function postEditPage($id)
	{
		$title    = Input::get('title');
		$url      = Input::get('url');
		$parentId = Input::get('parent_id');
		$visible  = Input::get('visible', false);
		$content  = Input::get('content');

		$data = array(

			'title'     => $title,
			'url'       => $url,
			'parent_id' => $parentId,
			'visible'   => $visible,
			'content'   => $content,

	 	);

	 	try {

			Page::change($id, $data);

		} catch (InvalidDataException $e) {

			$input = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($input)->withErrors($e->getErrors());
		}

		return Redirect::route('admin.pages')->with('global', 'Page edited');
	}

}