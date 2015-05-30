<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('currencies', function($table){

			$table->increments('id'); // идентификатор валюты
			
			$table->string('title', 30); // название валюты
			$table->string('code', 5); // код валюты
			$table->string('symbol', 20); // символ валюты
			$table->integer('position'); // расположение символа валюты (до или после числа)

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
		Schema::drop('currencies');
	}

}
