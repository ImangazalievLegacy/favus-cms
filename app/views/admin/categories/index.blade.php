@extends('admin.layout.main')

@section('title') Категории @stop

@section('head')
<script src="{{ URL::to('js/admin/categories.js') }}"></script>
@stop

@section('content')

	<h2>Категории</h2>

	<a href="{{ URL::route('admin.categories.add') }}">Add</a>

	@if (isset($categories) && count($categories)>0)

		<ol>

			@foreach ($categories as $category)

				@include('admin.categories.item')

			@endforeach

		</ol>

	@endif

	{{ $categories->links() }}

@stop