<?php

	$categories = Category::getAll();

	$lastLevel = 0;

	$path = array();

	foreach ($categories as $category):

		// полный путь категории
		if ($category->level > 0) 
		{

			if ($category->level <= $lastLevel)
			{
				$diff = $lastLevel - $category->level + 1;

				$newSize = count($path) - $diff;

				$path = array_slice($path, 0, $newSize);
			}
			
			$path[] = $category->url;

		}

		$url = URL::route('catalog.category', implode('/', $path));

		$tab = str_repeat('• ', $category->level);
?>
		{{ $tab }}<a href="{{ $url }}">{{ $category->title}}</a><br>
<?php
		$lastLevel = $category->level;

	endforeach;