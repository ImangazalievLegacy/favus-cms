@extends('admin.layout.main')

@section('title') Добавление товара @stop

@section('head')
	<link rel="stylesheet" href="{{ asset('/css/admin/product/add.css') }}">
@stop

@section('footer')
	<script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
	<script src="{{ asset('/js/admin/wysiwyg/init.js') }}"></script>
	<script src="{{ asset('/js/handlebars.js') }}"></script>
	<script src="{{ asset('/js/admin/products/upload.js') }}"></script>
@stop

@section('content')

	<form action="{{ URL::route('admin.products.add-post') }}" method="post" class="add-product">

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
			<label for="category_id" class="control-label">Категория</label>

			<select type="text" name="category_id" value="{{ (Input::old('category_id')) ? e(Input::old('category_id')) : '' }}" id="category_id" class="form-control">
				@if (isset($categories) && count($categories)>0)

					@foreach ($categories as $category)
							<option value="{{ $category->id }}">{{ $category->title }}</option>
					@endforeach

				@endif
			</select>

			@if ( $errors->has('category_id') )
				<span class="help-block text-danger"><p>{{ $errors->first('category_id') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="upload-dialog" class="control-label">Изображение товара</label>
			<input type="file" id="upload-dialog" class="form-control" data-url="{{ URL::route('api.call-method', 'files/images/upload') }}">
			<div class="upload-message"></div>
			
			<input type="hidden" name="main_image_id" id="main-image-id" value="{{ (Input::old('main_image_id')) ? e(Input::old('main_image_id')) : 0 }}">

			<div class="row" id="thumbnails">
				@if (Input::old('product_images') && count(Input::old('product_images')) > 0)

					<?php $i = 0; ?>

					@foreach (Input::old('product_images') as $path)
						<div class="col-xs-6 col-md-3">
							@if (Input::old('main_image_id') == $i++)
								<a href="#" class="thumbnail selected">
							@else
								<a href="#" class="thumbnail">
							@endif
								<img src="{{ URL::to($path) }}">
								<span class="delete">&times;</span>
							</a>
							<input type="hidden" name="product_images[]" value="{{ $path }}">
						</div>
					@endforeach

				@endif
			</div>

			<div id="upload-message">
				
			</div>

			<div class="progress" id="image-upload-progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>

		@include('admin.products.templates')

		<div class="form-group">
			<label for="description" class="control-label">Описание</label>
			<textarea name="description" rows="8" placeholder="Введите описание товара" id="description" class="form-control wysiwyg">{{ (Input::old('description')) ? e(Input::old('description')) : '' }}</textarea>
			@if ( $errors->has('description') )
				<span class="help-block text-danger"><p>{{ $errors->first('description') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="article_number" class="control-label">Артикул</label>
			<input type="text" name="article_number" size="30" value="{{ (Input::old('article_number')) ? e(Input::old('article_number')) : '' }}" placeholder="Введите артикул товара" id="article_number" class="form-control">
			@if ( $errors->has('article_number') )
				<span class="help-block text-danger"><p>{{ $errors->first('article_number') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="count" class="control-label">Количество</label>
			<input type="text" name="count" size="30" value="{{ (Input::old('count')) ? e(Input::old('count')) : '' }}" placeholder="Введите количество товара" id="count" class="form-control">
			@if ( $errors->has('count') )
				<span class="help-block text-danger"><p>{{ $errors->first('count') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="price" class="control-label">Цена</label>
			<input type="text" name="price" size="30" value="{{ (Input::old('price')) ? e(Input::old('price')) : '' }}" placeholder="Введите цену товара" id="price" class="form-control">
			@if ( $errors->has('price') )
				<span class="help-block text-danger"><p>{{ $errors->first('price') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="old_price" class="control-label">Старая цена</label>
			<input type="text" name="old_price" size="30" value="{{ (Input::old('old_price')) ? e(Input::old('old_price')) : '' }}" placeholder="Введите старую цену товара" id="old_price" class="form-control">
			@if ( $errors->has('old_price') )
				<span class="help-block text-danger"><p>{{ $errors->first('old_price') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="currency" class="control-label">Валюта</label>

			<select type="text" name="currency" value="{{ (Input::old('currency')) ? e(Input::old('currency')) : '' }}" id="currency" class="form-control">
				@if (isset($currencies) && count($currencies)>0)

					@foreach ($currencies as $currency)
						<option value="{{ $currency->code }}">{{ $currency->title }}</option>
					@endforeach

				@endif
			</select>

			@if ( $errors->has('currency') )
				<span class="help-block text-danger"><p>{{ $errors->first('currency') }}</p></span>
			@endif
		</div>

		<div class="form-group">
			<label for="visible"><input type="checkbox" name="visible" id="visible" value="1" checked> Отображать в каталоге</label>
			@if ( $errors->has('visible') )
				<span class="help-block text-danger"><p>{{ $errors->first('visible') }}</p></span>
			@endif
		</div>

		{{ Form::token() }}

		<button type="submit" class="btn btn-primary">Добавить</button>

	</form>

@stop