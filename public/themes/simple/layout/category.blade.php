@if ($category->level < $lastLevel)
	{{ str_repeat('</ul></li>', ($lastLevel - $category->level)) }}
@endif
<li class="{{ ($category->hasChild()) ? 'has-submenu' : '' }}">
	<a href="{{ URL::route('catalog.category', $category->getPath()) }}">{{ $category->title }}</a>
	@if ($category->hasChild())
		<ul>
	@else
		</li>
	@endif