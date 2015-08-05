@extends('layout.main')

@section('title', $product->title)

@section('head')
<link rel="stylesheet" href="{{ URL::to('css/product.css') }}">
@stop


@section('scripts')
<script src="{{ URL::to('js/catalog/card.js') }}"></script>
<script src="{{ URL::to('js/api/cart.js') }}"></script>
@stop

@section('content')

<article data-id="{{ $product->id }}">
	<div class="row">
		<div class="col-md-12 card">
			<div class="row">
				<div class="col-md-6">
					@if ($product->hasImages())
						<img src="{{ URL::to($product->getMainImage()) }}" alt="{{ $product->title }}" id="main-image">
					@else
						<img src="{{ theme_asset('assets/images/noimage.jpg') }}" alt="{{ $product->title }}" id="main-image">
					@endif
				</div>
				<div class="col-md-4">
					<div class="quick-add">
						<h1 itemprop="name">{{ $product->title }}</h1>
						<h2><span class="product-price">{{ Currency::addSymbol($product->price, $product->currency) }}</span></h2>
					</div>
					<button id="add-product">Add to cart</button>
				</div>
			</div>
			<div class="description">{{ $product->description }}</div>
		</div>
	</div>
</article>

@stop