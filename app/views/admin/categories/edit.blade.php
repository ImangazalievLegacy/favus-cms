@extends('admin.layout.main')

@section('title') Редактирование категории @stop

@section('content')

	<form action="{{ URL::route('admin.categories.edit-post', $category->id) }}" method="post">

		<div class="form-group">
			<label for="title" class="control-label">Название</label>
			<input type="text" name="title" size="30" value="{{ (Input::old('title')) ? e(Input::old('title')) : $category->title }}" placeholder="Введите название категории" id="title" class="form-control">
			@if ( $errors->has('title') )
				<span class="help-block text-danger"><p>{{ $errors->first('title') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="url" class="control-label">URL</label>
			<input type="text" name="url" size="30" value="{{ (Input::old('url')) ? e(Input::old('url')) : $category->url }}" placeholder="Введите URL категории" id="url" class="form-control">
			@if ( $errors->has('url') )
				<span class="help-block text-danger"><p>{{ $errors->first('url') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="parent_id" class="control-label">Родительская категория</label>

			<select type="text" name="parent_id" value="{{ (Input::old('parent_id')) ? e(Input::old('parent_id')) : '' }}" id="parent_id" class="form-control">
				@if (isset($categories) && count($categories)>0)

					@foreach ($categories as $parentCategory)
							@if ($category->id == $parentCategory->id)
								<option value="{{ $parentCategory->id }}" selected>{{ $parentCategory->title }}</option>
							@else
								<option value="{{ $parentCategory->id }}">{{ $parentCategory->title }}</option>
							@endif
					@endforeach

				@endif
			</select>

			@if ( $errors->has('parent_id') )
				<span class="help-block text-danger"><p>{{ $errors->first('parent_id') }}</p></span>
			@endif
		</div>

		{{ Form::token() }}

		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>


@stop