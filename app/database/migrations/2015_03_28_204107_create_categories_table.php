<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function($table){

			$table->increments('id'); // идентификатор категории
			$table->string('title', 30); // название категории
			$table->string('url', 30); // URL категории (ЧПУ)
			
			$table->integer('position'); // позиция элемента
			$table->integer('level'); // уровень вложенности
			$table->integer('parent_id')->nullable(); // идентификатор родительского элемента

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
		Schema::drop('categories');
	}

}
