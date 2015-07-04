@extends('layout.main')

@section('content')

	<h2>Корзина</h2>

	@if (isset($items) && count($items)>0)

		<ol>

			@foreach ($items as $item)

				@include('cart.item')

			@endforeach

		</ol>

		@if (Config::get('site/order.discount.enabled'))
			@if (Cart::getTotal(false) >= Config::get('site/order.discount.from'))

				<b>Скидка: </b> {{ Config::get('site/order.discount.percentage') }}%

			@endif
		@endif

		<br><b>Total:</b> {{ $total }} 

	@endif

	@if(!Cart::isEmpty())
		@if (Order::can())
			<br><br>
			<a href="{{ URL::route('order.make') }}"><button>Proceed to Checkout</button></a>
		@else
			<br>Вы не можете сделать заказ
		@endif
	@endif

@stop