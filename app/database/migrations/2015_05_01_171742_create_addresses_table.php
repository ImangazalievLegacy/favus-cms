<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('addresses', function($table){

			$table->increments('id'); // идентификатор адреса
			$table->integer('owner_id'); // идентификатор пользователя, которому принадлежит адрес
			
			$table->string('fullname', 30); // ФИО
			$table->string('country', 30); // страна
			$table->string('city', 30); // город
			$table->string('province', 30); // край/область/регион
			$table->string('zip_code', 30); // почтовый индекс 
			$table->string('phone_number', 30); // телефон получателя
			$table->string('email', 30); // E-mail получателя

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
		Schema::drop('addresses');
	}

}
