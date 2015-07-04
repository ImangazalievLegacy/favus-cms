<?php

if ( ! function_exists('theme_path'))
{
	/**
	 * Returns the absolute path to the file or folder in the theme.
	 *
	 * @param string $path relative path to the file
	 * @return string
	 */
	function theme_path($path = '')
	{
		if ($path !== '')
		{
			$path = '/'.$path;
		}

		$theme = Config::get('site/general.theme', 'default');

		return public_path('themes').'/'.$theme.$path;
	}

}

if ( ! function_exists('theme_asset'))
{
	/**
	 * Returns the absolute URL to the file or folder in the theme.
	 *
	 * @return string
	 */
	function theme_asset($path)
	{
		$theme = Config::get('site/general.theme', 'default');

		$path = 'themes/'.$theme.'/'.$path;

		return URL::to($path);
	}
}