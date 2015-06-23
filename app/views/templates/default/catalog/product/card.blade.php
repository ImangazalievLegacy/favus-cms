@extends('layout.main')

@section('head')
<script src="{{ URL::to('js/catalog/card.js') }}"></script>
<link rel="stylesheet" href="{{ URL::to('css/card.css') }}">
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

		@endif

		<p>{{ nl2br($product->description) }}</p>
		Price: <i>{{ $product->price }}</i>
		<br>

		<button id="add-product">Add To Cart</button>

		@if (Cart::has($product->id))

		<button type="submit" id="delete-product">Delete From Cart</button>

		@endif

	</article>

@stop