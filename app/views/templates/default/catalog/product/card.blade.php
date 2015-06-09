@extends('layout.main')

@section('head')
<script src="{{ URL::to('js/catalog/card.js') }}"></script>
@stop

@section('content')

	<article data-id="{{ $product->id }}">

		<h1>{{ $product->title }}</h1>

		<p>{{ $product->description }}</p>
		Price: <i>{{ $product->price }}</i>
		<br>

		<button type="submit" id="add-product">Add To Cart</button>

		@if (Cart::has($product->id))

		<button type="submit" id="delete-product">Delete From Cart</button>

		@endif

	</article>

@stop