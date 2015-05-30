<?php

class CategorySeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$root = Category::createRoot('Каталог');

		$tv = $root->addSub('Телевизоры', 'tv');
		$tv->addSub('ЭЛТ', 'crt');
		$tv->addSub('Плазменные', 'plasma');

		$phones = $root->addSub('Телефоны', 'phones');
		$phones->addSub('Смартфоны', 'smartphones');
		$phones->addSub('Домашние', 'home');

		$computers = $root->addSub('Компьютеры и ноутбуки', 'computers');
		$computers->addSub('Ноутбуки', 'notebooks');
		$computers->addSub('Аксессуары', 'accessories');

		$homeapp = $root->addSub('Бытовая техника', 'homeapp');
		$homeapp->addSub('Стиральные машины', 'washing-machine');
		$homeapp->addSub('Пылесосы', 'cleaner');
		$homeapp->addSub('Кондиционеры', 'conditioning');
	}

}