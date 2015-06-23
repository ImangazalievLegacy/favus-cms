@extends('layout.main')

@section('content')

	<h2>Каталог</h2>

	@if (isset($products) && count($products)>0)

		<ol>

			@foreach ($products as $product)

				@include('catalog.item')

			@endforeach

		</ol>

	@endif

	{{ $products->links() }}

@stop