@extends('admin.layout.main')

@section('title') Редактирование категории @stop

@section('content')

	<h2>Редактирование категории</h2>

	<form action="{{ URL::route('admin.categories.edit-post', $category->id) }}" method="post">

		Название:<br>
		<input type="text" name="title" size="30" value="{{ (Input::old('title')) ? e(Input::old('title')) : $category->title }}">
		@if ( $errors->has('title') )
			{{ $errors->first('title') }}
		@endif

		<br>URL:<br>
		<input type="text" name="url" size="30" value="{{ (Input::old('url')) ? e(Input::old('url')) : $category->url }}">
		@if ( $errors->has('url') )
			{{ $errors->first('url') }}
		@endif

		<br>Родительская категория:<br>
		<select name="parent_id">

			@if (isset($categories) && count($categories)>0)

				@foreach ($categories as $parentCategory)
					@if ($category->parent_id == $parentCategory->id)
						<option value="{{ $parentCategory->id }}" selected>{{ $parentCategory->title }}</option>
					@else
						<option value="{{ $parentCategory->id }}">{{ $parentCategory->title }}</option>
					@endif
				@endforeach

			@endif

		</select>

		@if ( $errors->has('parent_id') )
			{{ $errors->first('parent_id') }}
		@endif
		
		{{ Form::token() }}

		<br><input type="submit" value="Save">
	</form>


@stop