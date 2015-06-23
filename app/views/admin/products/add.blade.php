@extends('admin.layout.main')

@section('title') Добавление товара @stop

@section('head')
<script src="{{ asset('/js/admin/products/upload.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/admin/product/add.css') }}">
@stop


@section('content')

	<h2>Добавление товара</h2>

	<form action="{{ URL::route('admin.products.add-post') }}" method="post" class="add-product">

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

		<br>Категория:<br>
		<select name="category_id">

			@if (isset($categories) && count($categories)>0)

				@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->title }}</option>
				@endforeach

			@endif

		</select>

		@if ( $errors->has('category_id') )
			{{ $errors->first('category_id') }}
		@endif

		<br><br>Изображение товара:<br>
		<ul class="uploaded-images"></ul>
		<br>
		<input type="file" name="uploader">
		<br>

		<div class="upload-message"></div>

		<button class="upload-image" data-url="{{ URL::route('api.call-method', 'files/images/upload') }}">Загрузить</button>

		<div class="progress-bar-wrap">
			<div class="progress-bar"></div>
		</div>

		<br>Описание:<br>
		@if ( $errors->has('description') )
			{{ $errors->first('description') }}
			<br>
		@endif
		<textarea name="description" id="" cols="30" rows="10">{{ (Input::old('description')) ? e(Input::old('description')) : '' }}</textarea>

		<br>Артикул:<br>
		<input type="text" name="article_number" size="30" value="{{ (Input::old('article_number')) ? e(Input::old('article_number')) : '' }}">
		@if ( $errors->has('article_number') )
			{{ $errors->first('article_number') }}
		@endif

		<br>Цена:<br>
		<input type="text" name="price" size="30" value="{{ (Input::old('price')) ? e(Input::old('price')) : '' }}">
		@if ( $errors->has('price') )
			{{ $errors->first('price') }}
		@endif

		<br>Старая цена:<br>
		<input type="text" name="old_price" size="30" value="{{ (Input::old('old_price')) ? e(Input::old('old_price')) : '' }}">
		@if ( $errors->has('old_price') )
			{{ $errors->first('old_price') }}
		@endif

		<br>Валюта:<br>
		<select name="currency">

			@if (isset($currencies) && count($currencies)>0)

				@foreach ($currencies as $currency)
					<option value="{{ $currency->code }}">{{ $currency->title }}</option>
				@endforeach

			@endif

		</select>

		@if ( $errors->has('currency') )
			{{ $errors->first('currency') }}
		@endif
		
		{{ Form::token() }}

		<br><input type="submit" value="Add">
	</form>


@stop