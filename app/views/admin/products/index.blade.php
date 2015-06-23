@extends('admin.layout.main')

@section('title') Товары @stop

@section('head')
<script src="{{ URL::to('js/admin/products.js') }}"></script>
@stop

@section('content')

	<h2>Товары</h2>

	<a href="{{ URL::route('admin.products.add') }}">Add</a>

	@if (isset($products) && count($products)>0)

		<ol>

			@foreach ($products as $product)

				@include('admin.products.item')

			@endforeach

		</ol>

		{{ $products->links() }}

	@endif

@stop