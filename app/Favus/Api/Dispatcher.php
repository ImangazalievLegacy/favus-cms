<?php

namespace Favus\Api;

use Favus\Api\Exception;
use Favus\Api\Facades\Router;
use Favus\Api\Http\Response;
use \Request;

class Dispatcher
{
	function __construct($prefix = 'Api')
	{
		$dispatcher = new \Illuminate\Events\Dispatcher();

		$router = new Routing\Router($dispatcher);

		Router::setInstance($router);

		$prefix .= '\\Controllers';

		$router->setPrefix($prefix);

		$folder = dirname(str_replace('\\', '/', app_path() . '/' . $prefix));

		$routes =  $folder . '/routes.php';

		if (file_exists($routes))
		{
			require $routes;
		}

		$this->router = $router;

		\ClassLoader::addDirectories(array(

			app_path(),

		));		
	}

	public function checkToken()
	{
		if (\Config::get('app.debug'))
		{
			return true;
		}

		if (Request::ajax())
		{
			if ((\Session::getToken() != Request::header('X-CSRF-Token')) or (\Session::token() != \Input::get('_token')))
			{
				throw new Exception\InvalidTokenException('Token Mismatch Exception');
			}
		}
		else
		{
			//для приложения
			throw new Exception\InvalidTokenException('Invalid Token');
		}
	}

	public function checkDowntime()
	{
		if (\Config::get('site/general.downtime'))
		{
			throw new Exception\ForbiddenException('API is disabled');
		}
	}

	public function handle($path, $responseType = 'json')
	{
		$path = '/' . $path;

		$_SERVER['REQUEST_URI'] = $path;

        $request = Request::createFromGlobals();

		try {

			$this->checkToken();
			$this->checkDowntime();
			
			$content = Router::dispatch($request);

			if ($content === null)
			{
				$content = '';
			}

			if (!$content instanceof Response)
			{
				$response = new Response($content);
			}

		} catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {

			$response = Response::error(404, 'Not Found.');

		} catch (Exception\ApiException $e) {

			$response = Response::error($e->getCode(), $e->getMessage(), $e->getDescription());

		} catch (\Exception $e) {

			$message = $e->getMessage();

			$response = Response::error(500, 'Internal Server Error.', $message);
		} 

		$response->send();
	}
}