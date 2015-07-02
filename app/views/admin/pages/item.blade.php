<li data-id="{{ $page->id }}">
	<h3>{{ $page->title }}</h3>
	<a href="{{ URL::route('admin.pages.edit', $page->id) }}">Редактировать</a>
	<a href="" class="delete-page">Удалить</a>
</li>