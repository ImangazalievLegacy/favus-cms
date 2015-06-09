<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $hidden = array('password', 'remember_token');

	protected $fillable = array('username', 'email', 'password', 'hash', 'active', 'blocked', 'role');

	public static function register($data)
	{
		$rules = array(

			'email'     => 'required|max:50|email|unique:users',
			'username'  => 'required|max:30|min:3|unique:users',
			'password'  => 'required|min:6'

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		$activationCode = str_random(32);

		$user = User::create(array(

			'email'      => $data['email'],
			'username'   => $data['username'],
			'password'   => Hash::make($data['password']),
			'hash'       => $activationCode,
			'active'     => 0

		));

		return $user;
	}

	public static function validateLoginData($data)
	{
		$rules = array(

			'email'    => 'required|max:50|email',
			'password' => 'required|min:6'

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}
	}

	public static function activate($code)
	{
		$user = User::where('hash', '=', $code)->where('active', '=', 0);

		if ($user->count() == 0)
		{
			throw new NotFoundException('Not Found');
		}

		$user = $user->first();

		$user->active = 1;
		$user->hash   = '';

		return $user->save();
	}

	public static function resetPassword($data)
	{
		$rules = array(

			'password'  => 'required|min:6'

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		$code = Input::get('code');
		$password = Input::get('password');

		$user = User::where('hash', '=', $code);

		if ($user->count() == 0)
		{
			throw new NotFoundException('Not Found');
		}

		$user = $user->first();

		$user->password = Hash::make($password);
		$user->hash     = '';

		return $user->save();
	}

	public static function findByEmail($email)
	{
		$data = ['email' => $email];

		$rules = array(

			'email' => 'required|max:50|email',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		$user = User::where('email', '=', $email)->first();

		if ($user === null)
		{
			throw new NotFoundException('Not Found');
		}

		return $user;
	}

	public function generateHash($notActive = true)
	{
		if (($this->active == 1) and $notActive)
		{
			throw new NotFoundException('Not Found');
		}

		$activationCode = str_random(32);

		$this->hash = $activationCode;

		if ($this->save())
		{
			return $activationCode;
		}

		return false;
	}

}
