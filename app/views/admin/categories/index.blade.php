@extends('admin.layout.main')

@section('title') Категории @stop

@section('footer')
<script src="{{ URL::to('js/admin/categories.js') }}"></script>
@stop

@section('content')

	<a href="{{ URL::route('admin.categories.add') }}" class="btn btn-primary">
		<span class="fa fa-fw fa-plus" aria-hidden="true"></span>&nbsp;Добавить
	</a>

	@if (isset($categories) && count($categories)>0)

		<ol>

			@foreach ($categories as $category)

				@include('admin.categories.item')

			@endforeach

		</ol>

		{{ $categories->links() }}
		
	@endif

@stop