<?php

namespace Favus\Api;

use Favus\Api\Exception;

class ApiDispatcher
{
	/**
	 * @var Favus\Api\Router;
	 */
	protected $router;
	
	function __construct()
	{
		$dispatcher = new \Illuminate\Events\Dispatcher();

		$router = new Router($dispatcher);

		$prefix = __NAMESPACE__ . '\\Controllers\\';

		$router->setPrefix($prefix);

		require __DIR__ . '/' . 'routes.php';

		$this->router = $router;
	}

	public function checkToken()
	{
		return true;

		if (\Request::ajax())
		{
			if ((\Session::getToken() != \Request::header('X-CSRF-Token')) or (\Session::token() != \Input::get('_token')))
			{
				throw new Exception\InvalidTokenException;
			}
		}
		else
		{
			//для приложения
			throw new Exception\InvalidTokenException;
		}
	}

	public function handle($path, $responseType = 'json')
	{
		$path = '/' . $path;

		$server = $_SERVER;

		$_SERVER['REQUEST_URI'] = $path;

        $request = \Request::createFromGlobals();

		try {
			
			$content = $this->router->dispatch($request);

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

			$response = Response::error(500, 'Internal Server Error.', $e->getMessage());

		} 

		$response->send();
	}
}