@extends('admin.layout.main')

@section('title') Добавление категории @stop

@section('content')

	<form action="{{ URL::route('admin.categories.add-post') }}" method="post">

		<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
			<label for="title" class="control-label">Название</label>
			<input type="text" name="title" size="30" value="{{ (Input::old('title')) ? e(Input::old('title')) : '' }}" placeholder="Введите название категории" id="title" class="form-control">
			@if ( $errors->has('title') )
				<span class="help-block"><p>{{ $errors->first('title') }}</p></span>
			@endif
		</div>

		<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
			<label for="url" class="control-label">URL</label>
			<input type="text" name="url" size="30" value="{{ (Input::old('url')) ? e(Input::old('url')) : '' }}" placeholder="Введите URL категории" id="url" class="form-control">
			@if ( $errors->has('url') )
				<span class="help-block"><p>{{ $errors->first('url') }}</p></span>
			@endif
		</div>

		<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
			<label for="parent_id" class="control-label">Родительская категория</label>

			<select type="text" name="parent_id" value="{{ (Input::old('parent_id')) ? e(Input::old('parent_id')) : '' }}" id="parent_id" class="form-control">
				@if (isset($categories) && count($categories)>0)

					@foreach ($categories as $category)
							@if (Input::has('parent_id') and ($category->id == Input::old('parent_id')))
								<option value="{{ $category->id }}" selected>{{ $category->title }}</option>
							@else
								<option value="{{ $category->id }}">{{ $category->title }}</option>
							@endif
					@endforeach

				@endif
			</select>

			@if ( $errors->has('parent_id') )
				<span class="help-block"><p>{{ $errors->first('parent_id') }}</p></span>
			@endif
		</div>

		{{ Form::token() }}

		<button type="submit" class="btn btn-primary">Добавить</button>
	</form>


@stop