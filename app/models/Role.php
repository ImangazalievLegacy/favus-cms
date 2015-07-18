<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {
	
	protected $table = 'roles';

	public static function findByName($name)
	{
		return Role::where('name', $name)->limit(1)->get()->first();
	}
}