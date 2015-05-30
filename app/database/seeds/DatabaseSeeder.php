<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CurrenciesSeeder');
		$this->call('ShippingSeeder');
		$this->call('CategorySeeder');
		$this->call('ProductsSeeder');
	}

}
