<?php

	$theme = Config::get('site/general.theme', 'default');

	View::addLocation(app('path') . '/views/templates/' . $theme);