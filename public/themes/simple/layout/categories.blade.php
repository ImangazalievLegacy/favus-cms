<?php $categories = Category::getAll(false); ?>

<?php $lastLevel = 1; ?>

<ul class="side-nav">
@if ((isset($categories)) and (count($categories) > 0))
	@foreach ($categories as $category)
		@include('layout.category')
				
		<?php $lastLevel = $category->level; ?>
	@endforeach
@endif
@if (1 < $lastLevel)
	{{ str_repeat('</ul></li>', ($lastLevel - 1)) }}
@endif
</ul>