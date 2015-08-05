@extends('layout.main')

@section('title', 'Корзина')

@section('content')

	<div id="breadcrumb">
		<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<a href="{{ URL::route('home') }}" itemprop="url">
				<span itemprop="title">Home</span>
			</a>
		</span>
		—
		<a href="{{ URL::route('cart.index') }}" class="active">Cart</a>
	</div>

	<h1>Cart</h1>

	@if (isset($items) && count($items)>0)

		<table class="products-table">
			<thead>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th class="price">Price</th>
					<th>Quantity</th>
					<th>Total</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $item)

					@include('cart.item')

				@endforeach	
			</tbody>
		</table>

		<div class="row total">
			<h2>Total {{ $total }}</h2>
		</div>
	@else
		<h2>Your cart is empty</h2>
	@endif

	@if (Config::get('site/order.discount.enabled'))
		@if (Cart::getTotal(false) >= Config::get('site/order.discount.from'))

			<b>Скидка: </b> {{ Config::get('site/order.discount.percentage') }}%

		@endif
	@endif

	@if(!Cart::isEmpty())
		@if (Order::can())
			<a href="{{ URL::route('order.make') }}"><button class="checkout">Check out</button></a>
		@else
			<h2>You can't make an order</h2>
		@endif
	@endif

@stop