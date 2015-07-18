<?php

namespace Favus\Api\Routing;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Router extends \Illuminate\Routing\Router {

	protected $prefix = '';

	protected function addRoute($methods, $uri, $action)
	{
		return $this->routes->add($this->createRoute($methods, $uri, $this->prefix . $action));
	}

	public function getPrefix()
	{
	    return $this->prefix;
	}
	
	public function setPrefix($prefix)
	{
	    $this->prefix = $prefix;
	    
	    return $this;
	}

	public function dispatch(Request $request)
	{
		$this->currentRequest = $request;

		$response = $this->callFilter('before', $request);

		if (is_null($response))
		{
			$response = $this->dispatchToRoute($request);
		}

		$this->callFilter('after', $request, $response);

		return $response;
	}

	public function dispatchToRoute(Request $request)
	{
		$route = $this->findRoute($request);

		$this->events->fire('router.matched', array($route, $request));

		$response = $route->run($request);

		return $response;
	}
}
