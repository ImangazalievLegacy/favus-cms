<?php

class AccountController extends BaseController {

	public function postCreate()
	{
		$data = Input::all();

		try {

			$user = User::register($data);

		} catch (InvalidDataException $e) {

			return Redirect::back()->with('global', $e->getMessage())->withInput($data)->withErrors($e->getErrors());
		}

		Mail::send('emails.auth.activate', array('username' => $user->username, 'link' => URL::route('account.activate', $user->hash)), function($message) use ($user) {

			$message->to($user->email, $user->username)->subject('Activate your account');
				
		});

		return Redirect::route('home')->with('global', 'Your account has been created! We have sent you an email to activate your account');
	}

	public function postLogin()
	{
		$data = Input::all();

		try {

			User::validateLoginData($data);

		} catch (InvalidDataException $e) {

			return Redirect::back()->with('global', $e->getMessage())->withInput($data)->withErrors($e->getErrors());
		}

		$remember = (Input::has('remember')) ? true : false;

		$auth = Auth::attempt(array(

			'email'    => Input::get('email'),
			'password' => Input::get('password'),
			'active'   => 1

		), $remember);

		if ($auth)
		{
			if (Input::has('redirect'))
			{
				return Redirect::to(Input::get('redirect'));
			}
			else
			{
				return Redirect::intended('/');
			}
		}
		else
		{
			return Redirect::route('account.login')->with('global', 'Email/password wrong or account not activated')->withInput($data);
		}

		return Redirect::route('account.login')->with('global', 'There was a problem signing you in');
	}

	public function getCreate()
	{
		return View::make('account.create');
	}

	public function getLogin()
	{
		return View::make('account.login');
	}

	public function getLogOut()
	{
		Auth::logout();

		return Redirect::route('home');
	}

	public function getActivate($code)
	{
		try {

			if ($user = User::activate($code))
			{
				if (Config::get('site/registration.autologin'))
				{
					$auth = Auth::loginUsingId($user->id);

					return Redirect::route('home');
				}
				else
				{
					return Redirect::route('home')->with('global', 'Activated! You can now sign in');
				}
			}

		} catch (NotFoundException $e) {

			return Redirect::route('home')->with('global', 'We could not activate your account now. Try again later.');
		}

		return Redirect::route('home')->with('global', 'We could not activate your account now. Try again later.');
	}

	public function getForgotPassword()
	{
		return View::make('account.forgot-password');
	}

	public function postForgotPassword()
	{
		$data = Input::all();

		$email = Input::get('email');

		try {

			$user = User::findByEmail($email);

			if ($code = $user->generateHash(false))
			{
				Mail::send('emails.auth.reset-password', array('username' => $user->username, 'link' => URL::route('account.password.reset', $code)), function($message) use ($user) {

					$message->to($user->email, $user->username)->subject('Password reset');
				
				});

				return Redirect::route('home')->with('global', 'We have sent you instruction by email.');
			}

		} catch (InvalidDataException $e) {

			return Redirect::back()->with('global', $e->getMessage())->withInput($data)->withErrors($e->getErrors());

		} catch (NotFoundException $e) {

			return Redirect::back()->with('global', $e->getMessage())->withInput($data);
		}

		return Redirect::route('account.forgot.password')->with('global', 'Could not request new password');
	}

	public function getResetPassword($code)
	{
		return View::make('account.reset-password')
			->with('code', $code);
	}

	public function postResetPassword()
	{
		$data = Input::all();

		try {

			if (User::resetPassword($data))
			{
				return Redirect::route('home')->with('global', 'Your password has been changed and you can sign in with your new password.');
			}

		} catch (NotFoundException $e) {

			return Redirect::back()->with('global', $e->getMessage())->withInput($data);
		}

		return Redirect::route('account.password.reset')->with('global', 'Your password could no be change');
	}

	public function getResendCode()
	{
		return View::make('account.resend-activation-code');
	}

	public function postResendCode()
	{

		if (Session::has('last_mail_time'))
		{
			list($ms, $seconds) = explode(' ', microtime());

			$diff = $seconds - Session::get('last_mail_time');

			if ($diff < 60*5)
			{
				return Redirect::route('home')->with('global', 'You have reached the limit. Please try again later');
			}
		}

		try {
			$email = Input::get('email');

			$user = User::findByEmail($email);

			if ($code = $user->generateHash())
			{
				Mail::send('emails.auth.activate', array('username' => $user->username, 'link' => URL::route('account.activate', $code)), function($message) use ($user) {

					$message->to($user->email, $user->username)->subject('Activate your account');
				
				});

				list($ms, $seconds) = explode(' ', microtime());
				Session::put('last_mail_time', $seconds);

				return Redirect::route('home')->with('global', 'We have sent you an email to activate your account');
			}

		} catch (InvalidDataException $e) {

			$data = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($data)->withErrors($e->getErrors());

		} catch (NotFoundException $e) {

			$data = Input::all();

			return Redirect::back()->with('global', $e->getMessage())->withInput($data);
		}

		return Redirect::route('resend.activation.code')->with('global', 'Could not resend activation code');
	}
}