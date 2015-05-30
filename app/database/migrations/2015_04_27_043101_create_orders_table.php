<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('orders', function($table){

			$table->increments('id'); // идентификатор заказа
			
			$table->string('type'); // тип заказчика (гость/зарегистрированный пользователь)
			$table->integer('owner_id'); // идентификатор пользователя
			$table->integer('address_id'); // идентификатор адреса
			$table->string('fullname', 30); // ФИО заказчика
			$table->string('email', 50); // E-mail заказчика
			$table->string('phone_number', 50); // телефон заказчика
			$table->string('ip_address', 50); // IP-адрес заказчика

			$table->text('product_list'); // список заказанных товаров
			$table->text('comment'); // комментарий к заказу
			$table->integer('total'); // общая цена всех товаров (итого)

			$table->string('status', 30); // статус заказа
			$table->timestamp('added_on'); // дата и время добавления заказа
			

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
		Schema::drop('orders');
	}

}
