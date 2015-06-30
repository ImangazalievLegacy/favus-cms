@extends('admin.layout.main')

@section('title') Товары @stop

@section('footer')
<script src="{{ URL::to('js/admin/products.js') }}"></script>
@stop

@section('content')

	<a href="{{ URL::route('admin.products.add') }}" class="btn btn-primary">
		<span class="fa fa-fw fa-plus" aria-hidden="true"></span>&nbsp;Добавить
	</a>

	@if (isset($products) && count($products)>0)

		<ol>

			@foreach ($products as $product)

				@include('admin.products.item')

			@endforeach

		</ol>

		{{ $products->links() }}

	@endif

@stop