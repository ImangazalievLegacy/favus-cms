@extends('admin.layout.main')

@section('title') Редактирование товара @stop

@section('content')

	<h2>Редактирование товара</h2>

	<form action="{{ URL::route('admin.products.edit-post', $product->id) }}" method="post">

		Название:<br>
		<input type="text" name="title" size="30" value="{{ (Input::old('title')) ? e(Input::old('title')) : $product->title }}">
		@if ( $errors->has('title') )
			{{ $errors->first('title') }}
		@endif

		<br>URL:<br>
		<input type="text" name="url" size="30" value="{{ (Input::old('url')) ? e(Input::old('url')) : $product->url }}">
		@if ( $errors->has('url') )
			{{ $errors->first('url') }}
		@endif

		<br>Категория:<br>
		<select name="category_id">

			@if(isset($categories) && count($categories)>0)

				@foreach ($categories as $category)
					@if ($product->id == $category->id)
						<option value="{{ $category->id }}" selected>{{ $category->title }}</option>
					@else
						<option value="{{ $category->id }}">{{ $category->title }}</option>
					@endif
				@endforeach

			@endif

		</select>

		@if ( $errors->has('category_id') )
			{{ $errors->first('category_id') }}
		@endif

		<br>Описание:<br>
		@if ( $errors->has('description') )
			{{ $errors->first('description') }}
			<br>
		@endif
		<textarea name="description" id="" cols="30" rows="10">{{ (Input::old('description')) ? e(Input::old('description')) : $product->description }}</textarea>

		<br>Артикул:<br>
		<input type="text" name="article_number" size="30" value="{{ (Input::old('article_number')) ? e(Input::old('article_number')) : $product->article_number }}">
		@if ( $errors->has('article_number') )
			{{ $errors->first('article_number') }}
		@endif

		<br>Цена:<br>
		<input type="text" name="price" size="30" value="{{ (Input::old('price')) ? e(Input::old('price')) : $product->price }}">
		@if ( $errors->has('price') )
			{{ $errors->first('price') }}
		@endif

		<br>Старая цена:<br>
		<input type="text" name="old_price" size="30" value="{{ (Input::old('old_price')) ? e(Input::old('old_price')) : $product->old_price }}">
		@if ( $errors->has('old_price') )
			{{ $errors->first('old_price') }}
		@endif

		<br>Валюта:<br>
		<select name="currency">

			@if(isset($currencies) && count($currencies)>0)

				@foreach ($currencies as $currency)
					@if ($product->currency == $currency->code)
						<option value="{{ $currency->code }}" selected>{{ $currency->title }}</option>
					@else
						<option value="{{ $currency->code }}">{{ $currency->title }}</option>
					@endif
				@endforeach

			@endif

		</select>

		@if ( $errors->has('currency') )
			{{ $errors->first('currency') }}
		@endif
		
		{{ Form::token() }}

		<br><input type="submit" value="Save">
	</form>


@stop