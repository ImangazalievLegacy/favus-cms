@extends('layout.main')

@section('head')
<link rel="stylesheet" href="{{ URL::to('css/product.css') }}">
@stop

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