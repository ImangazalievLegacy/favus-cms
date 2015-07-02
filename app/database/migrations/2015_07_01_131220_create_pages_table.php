<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function($table){

			$table->increments('id'); // идентификатор страницы
			$table->string('title', 64); // название страницы
			$table->string('url', 128); // URL страницы (ЧПУ)
			$table->boolean('visible'); // видимость страницы
			$table->text('content'); // содержимое страницы
			
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
		Schema::drop('pages');
	}

}
