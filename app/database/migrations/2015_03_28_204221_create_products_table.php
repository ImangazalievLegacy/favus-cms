<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('products', function($table){

			$table->increments('id'); // идентификатор товара
			$table->string('title', 256); // название товара
			$table->text('description'); // описание товара
			$table->text('images'); // изображения товара
			$table->text('main_image_id'); // идентификатор главного изображения товара

			$table->string('url', 512); // URL товара (ЧПУ)
			$table->integer('category_id'); // идентификатор категории товара

			$table->integer('price'); // цена товара
			$table->integer('old_price'); // старая цена товара
			$table->string('currency', 16); // код валюты, в которой указана цена товара

			$table->string('article_number', 32); // артикул товара
			$table->string('type', 32); // тип товара (обычный/комплект/электронный)
			$table->integer('count'); // количество товара

			$table->boolean('visible'); // флаг видимости товара

			$table->timestamps();

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}