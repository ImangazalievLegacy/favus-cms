<li data-id="{{ $product->id }}">
	<h3><a href="{{ URL::route('product.show', $product->url) }}">{{ $product->title }}</a></h3>
	<a href="{{ URL::route('admin.products.edit', $product->id) }}">Edit</a> <a href="" class="delete-product">Delete</a>
</li>