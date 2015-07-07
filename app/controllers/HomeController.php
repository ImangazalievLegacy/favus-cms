<?php

class HomeController extends BaseController {

	public function home()
	{
		return View::make('home');
	}

	public function downtime()
	{
		return View::make('closed');
	}

}