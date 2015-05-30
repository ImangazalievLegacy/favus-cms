<?php

class CurrenciesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Currency::truncate();

		$currencies = array(

			array(

				'title'    => 'Рубль',
				'code'     => 'RUB',
				'symbol'   => 'руб.',
				'position' => Currency::POSITION_AFTER,

			),

			array(

				'title'    => 'Евро',
				'code'     => 'EUR',
				'symbol'   => '€',
				'position' => Currency::POSITION_BEFORE,

			),

			array(

				'title'    => 'Доллар США',
				'code'     => 'USD',
				'symbol'   => '$',
				'position' => Currency::POSITION_BEFORE,

			),

		);

		foreach ($currencies as $currency) {
			
			Currency::create($currency);

		}

	}

}
