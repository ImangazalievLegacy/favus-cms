<?php

class ProductsSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Product::truncate();
		
		$faker = Faker\Factory::create();

		$categoryIds = Category::lists('id');

		for ($i=0; $i < 50; $i++)
		{ 

			$currencies = Currency::getCodes();
			$currency   = $currencies[array_rand($currencies)];

			Product::create([
				'title'          => $faker->sentence(3),
				'description'    => $faker->paragraph(20),

				'category_id'    => $categoryIds[array_rand($categoryIds)],
				'url'            => $faker->word,

				'price'          => mt_rand(100, 30000),
				'old_price'      => mt_rand(30000, 50000),

				'article_number' => $faker->ean13(),
				'currency'       => $currency
			]);

		}
	}

}
