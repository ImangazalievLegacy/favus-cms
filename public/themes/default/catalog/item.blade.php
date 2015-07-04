<li>
	@if ($product->hasImages())

		<div class="product-image">
			<img src="{{ URL::to($product->getMainImage()) }}" alt="">
		</div>

	@else

		<div class="product-image">
			<img src="{{ URL::to('images/noimage.jpg') }}" alt="">
		</div>

	@endif

	<h3><a href="{{ URL::route('product.show', $product->url) }}">{{ $product->title }}</a></h3>
	<p>{{ $product->description }}</p>
</li>