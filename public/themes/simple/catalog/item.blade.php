<div class="product col-md-4">
	<a href="{{ URL::route('product.show', $product->url) }}">
		@if ($product->count == 0)
			<div class="sold-out">Нет в наличии</div>
		@endif
		@if ($product->hasImages())
			<img src="{{ URL::to($product->getMainImage()) }}" alt="{{ $product->title }}">
		@else
			<img src="{{ theme_asset('assets/images/noimage.jpg') }}" alt="{{ $product->title }}">
		@endif
		
		<h3>{{ $product->title }}</h3>
		<h4>{{ Currency::addSymbol($product->price, $product->currency) }}</h4>
	</a>
</div>