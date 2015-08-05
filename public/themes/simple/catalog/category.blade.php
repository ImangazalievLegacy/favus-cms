@extends('layout.main')

@section('title', $category->title)

@section('content')

	<h2>{{ $category->title }}</h2>

	<div class="row products">
		@if (isset($products) && count($products)>0)
			@foreach ($products as $product)
				@include('catalog.item')
			@endforeach
		@endif
	</div>

	{{ $products->links() }}

@stop