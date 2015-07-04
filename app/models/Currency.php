<?php

class Currency extends Eloquent {

	protected $table = 'currencies';

	protected $fillable = array('title', 'code', 'symbol', 'position');

	const POSITION_BEFORE = 1;
	const POSITION_AFTER = 2;

	public static function getCodes()
	{
		return Currency::lists('code');
	}

	public static function findByCode($code)
	{
		return Currency::where('code', $code)->limit(1)->get()->first();
	}

	public static function addSymbol($number, $code = null)
	{
		if ($code === null)
		{
			$code = Config::get('site/general.currency');
		}

		$currency = Currency::findByCode($code);

		if ($currency->position === Currency::POSITION_BEFORE)
		{
			return $currency->symbol . $number;
		}
		else
		{
			return $number . ' ' . $currency->symbol;
		}
	}
}