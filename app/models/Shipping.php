<?php

class Shipping extends Eloquent {

	protected $table = 'shipping';

	protected $fillable = array('title', 'lang_code', 'cost', 'delivery_time', 'status');

	const STATUS_DISABLED = 0;
	const STATUS_ENABLED  = 1;

	public static function getTitles() {

		return Shipping::where('status', '=', self::STATUS_ENABLED)->lists('title');

	}

	public static function getIds() {

		return Shipping::where('status', '=', self::STATUS_ENABLED)->lists('id');

	}

	public static function getMethods() {

		return Shipping::where('status', '=', self::STATUS_ENABLED)->get();

	}

}
