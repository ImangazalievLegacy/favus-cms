@extends('admin.layout.main')

@section('title') Страницы @stop

@section('footer')
<script src="{{ URL::to('js/admin/pages.js') }}"></script>
@stop

@section('content')

	<a href="{{ URL::route('admin.pages.add') }}" class="btn btn-primary">
		<span class="fa fa-fw fa-plus" aria-hidden="true"></span>&nbsp;Добавить
	</a>

	@if (isset($pages) && count($pages)>0)

		<ol>

			@foreach ($pages as $page)

				@include('admin.pages.item')

			@endforeach

		</ol>

		{{ $pages->links() }}

	@endif

@stop