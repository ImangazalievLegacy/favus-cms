@extends('layout.main')

@section('content')

	<h2>Корзина</h2>

	@if(isset($items) && count($items)>0)

		<ol>

			@foreach ($items as $item)

				@include('cart.item')

			@endforeach

		</ol>

		<b>Total:</b> {{ $total }} 

	@endif

	@if(!Cart::isEmpty())
		<br><br>
		<a href=""><button>Proceed to Checkout</button></a>
	@endif

@stop