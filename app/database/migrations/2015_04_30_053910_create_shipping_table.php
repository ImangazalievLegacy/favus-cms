<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping', function($table){

			$table->increments('id')->unsigned(); // идентификатор способа доставки
			
			$table->string('title', 50); // название способа доставки
			$table->string('lang_code', 5); // код локали, для которой доступен данный способ доставки

			$table->decimal('cost', 30); // стоимость доставки
			$table->string('currency', 30); // код валюты, в которой указана цена
			$table->string('delivery_time', 30); // время доставки

			$table->boolean('status'); // статус (включен/выключен)

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
		Schema::drop('shipping');
	}

}
