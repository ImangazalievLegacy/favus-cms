<?php

namespace Favus\Installation;

use \User;
use \Role;
use \Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class Installer extends \BaseController
{
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
	}

	public function createAdminAccount($email, $username, $password)
	{
		try {

			$data = array(

				'email'      => $email,
				'username'   => $username,
				'password'   => $password,
				'active'     => 1
			);

			$user = User::register($data);

			$administrator = Role::findByName('Administrator');

			$user->attachRole($administrator);

		} catch (Exception $e) {

			throw new Exception($e->getMessage());

		}
	}

	public function migrate()
	{
		$output = new BufferedOutput;

		try {

			Artisan::call('migrate', array('--force' => true), $output);
			
		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

		return $output->fetch();
	}

	public function seed()
	{
		$output = new BufferedOutput;
		
		try {

			Artisan::call('db:seed', array(), $output);
			
		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

		return $output->fetch();
	}
}