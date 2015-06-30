<li data-id="{{ $product->id }}">
	<h3>{{ $product->title }}</h3>
	<a href="{{ URL::route('admin.products.edit', $product->id) }}">Редактировать</a>
	<a href="" class="delete-product">Удалить</a>
</li>