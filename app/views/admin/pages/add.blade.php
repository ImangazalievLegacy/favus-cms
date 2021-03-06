@extends('admin.layout.main')

@section('title') Добавление товара @stop

@section('footer')
	<script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
	<script src="{{ asset('/js/admin/wysiwyg/init.js') }}"></script>
	<script src="{{ asset('/js/handlebars.js') }}"></script>
@stop

@section('content')

	<form action="{{ URL::route('admin.pages.add-post') }}" method="post">

		<div class="form-group">
			<label for="title">Название</label>
			<input type="text" name="title" size="30" value="{{ (Input::old('title')) ? e(Input::old('title')) : '' }}" placeholder="Введите название товара" id="title" class="form-control">
			@if ( $errors->has('title') )
				<span class="help-block text-danger"><p>{{ $errors->first('title') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="url" class="control-label">URL</label>
			<input type="text" name="url" size="30" value="{{ (Input::old('url')) ? e(Input::old('url')) : '' }}" placeholder="Введите URL товара" id="url" class="form-control">
			@if ( $errors->has('url') )
				<span class="help-block text-danger"><p>{{ $errors->first('url') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="content" class="control-label">Описание</label>
			<textarea name="content" rows="8" placeholder="Введите описание товара" id="content" class="form-control wysiwyg">{{ (Input::old('content')) ? e(Input::old('content')) : '' }}</textarea>
			@if ( $errors->has('content') )
				<span class="help-block text-danger"><p>{{ $errors->first('content') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="visible"><input type="checkbox" name="visible" id="visible" value="1" checked> Видна всем</label>
			@if ( $errors->has('visible') )
				<span class="help-block text-danger"><p>{{ $errors->first('visible') }}</p></span>
			@endif
		</div>

		{{ Form::token() }}

		<button type="submit" class="btn btn-primary">Добавить</button>

	</form>

@stop