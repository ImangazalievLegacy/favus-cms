<?php

namespace Favus\Installation;

use \Role;
use \Auth;

class Installer extends \BaseController
{
	public function run()
	{
		$this->setupRoles();
	}

	public function setupRoles()
	{
		$administrator = new Role();
		$administrator->name = 'Administrator';
		$administrator->save();

		$manager = new Role();
		$manager->name = 'Manager';
		$manager->save();

		$customer = new Role();
		$customer->name = 'Customer';
		$customer->save();

		Auth::user()->attachRole($administrator);

		return 'Права успешно установлены';
	}
}