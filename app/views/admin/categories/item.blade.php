@if ($category->parent_id !== null)
	<li data-id="{{ $category->id }}">
		<h3>{{ $category->title }}</h3>
		<a href="{{ URL::route('admin.categories.edit', $category->id) }}">Edit</a> <a href="" class="delete-category">Delete</a>
	</li>
@endif