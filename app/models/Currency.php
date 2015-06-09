<?php

class Currency extends Eloquent {

	protected $table = 'currencies';

	protected $fillable = array('title', 'code', 'symbol', 'position');

	const POSITION_BEFORE = 1;
	const POSITION_AFTER = 2;

	public static function getCodes() {

		return Currency::lists('code');

	}

}