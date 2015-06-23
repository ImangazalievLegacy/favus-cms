@extends('admin.layout.main')

@section('title') Добавление категории @stop

@section('content')

	<h2>Добавление категории</h2>

	<form action="{{ URL::route('admin.categories.add-post') }}" method="post">

		Название:<br>
		<input type="text" name="title" size="30" value="{{ (Input::old('title')) ? e(Input::old('title')) : '' }}">
		@if ( $errors->has('title') )
			{{ $errors->first('title') }}
		@endif

		<br>URL:<br>
		<input type="text" name="url" size="30" value="{{ (Input::old('url')) ? e(Input::old('url')) : '' }}">
		@if ( $errors->has('url') )
			{{ $errors->first('url') }}
		@endif

		<br>Родительская категория:<br>
		<select name="parent_id">

			@if (isset($categories) && count($categories)>0)

				@foreach ($categories as $category)
						<option value="{{ $category->id }}">{{ $category->title }}</option>
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