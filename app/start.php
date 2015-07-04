<?php

	require app_path().'/Favus/helpers.php';

	View::addLocation(theme_path());

	/*
	* Обработчики ошибок
	*/

	App::error(function(Exception $exception, $code)
	{
		if (!Config::get('app.debug'))
		{
			switch ($code)
			{
				case 403:
					return Response::make(View::make('error/403'), 403);
				case 500:
					return Response::make(View::make('error/500'), 500);
				default:
					return Response::make(View::make('error/404'), 404);
			}
		}
	});

	App::down(function()
	{
		return Response::make(View::make('error/503'), 503);
	});