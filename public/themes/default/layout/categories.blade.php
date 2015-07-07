<?php 

	$categories = Category::getAll();

?>

@foreach ($categories as $category)
		{{ str_repeat('• ', $category->level) }} <a href="{{ URL::route('catalog.category', $category->getPath()) }}">{{ $category->title}}</a><br>
@endforeach