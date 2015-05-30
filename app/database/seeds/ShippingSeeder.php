<?php

class ShippingSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Shipping::truncate();

		$shippingMethods = array(

			array(

				'title'         => 'Самовывоз',
				'lang_code'     => 'RU',
				'cost'          => '0',
				'currency'      => 'RUB',
				'delivery_time' => '0 дней',
				'status'      => Shipping::STATUS_ENABLED,

			),

			array(

				'title'         => 'Почта',
				'lang_code'     => 'RU',
				'cost'          => '200',
				'currency'      => 'RUB',
				'delivery_time' => '7-15 дней',
				'status'      => Shipping::STATUS_ENABLED,

			),

			array(

				'title'         => 'Курьер',
				'lang_code'     => 'RU',
				'cost'          => '500',
				'currency'      => 'RUB',
				'delivery_time' => '1 день',
				'status'      => Shipping::STATUS_ENABLED,

			),

		);

		foreach ($shippingMethods as $shippingMethod) {
			
			Shipping::create($shippingMethod);

		}
	}

}
