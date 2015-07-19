@extends('layout.main')

@section('head')
<link rel="stylesheet" href="{{ URL::to('css/product.css') }}">
@stop


@section('footer')
<script src="{{ URL::to('js/catalog/card.js') }}"></script>
<script src="{{ URL::to('js/api/cart.js') }}"></script>
@stop

@section('content')
	<article data-id="{{ $product->id }}">

		<h1>{{ $product->title }}</h1>

		@if ($product->hasImages())

			@foreach ($product->getImages() as $image)

				<div class="product-image">
					<img src="{{ URL::to($image) }}" alt="">
				</div>

			@endforeach

		@else

			<div class="product-image">
				<img src="{{ URL::to('images/noimage.jpg') }}" alt="">
			</div>

		@endif

		<p>{{ $product->description }}</p>
		Price: <i>{{ Currency::addSymbol($product->price, $product->currency) }}</i>
		<br>

		<button id="add-product">Add To Cart</button>

		@if (Cart::has($product->id))

		<button type="submit" id="delete-product">Delete From Cart</button>

		@endif

	</article>
@stop