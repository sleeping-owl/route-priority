<?php namespace SleepingOwl\RoutePriority;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router as IlluminateRouter;

class Router extends IlluminateRouter
{

	const HIGH = 100;
	const MEDIUM = 50;
	const LOW = 0;

	/**
	 * Create a new Router instance.
	 *
	 * @param  Dispatcher  $events
	 * @param  Container  $container
	 * @return void
	 */
	public function __construct(Dispatcher $events, Container $container = null)
	{
		parent::__construct($events, $container);
		$this->routes = new RouteCollection;
	}

	/**
	 * Create a new Route object.
	 *
	 * @param  array|string  $methods
	 * @param  string  $uri
	 * @param  mixed   $action
	 * @return Route
	 */
	protected function newRoute($methods, $uri, $action)
	{
		$route = new Route($methods, $uri, $action);
		$priority = Router::MEDIUM - $this->routes->count();
		$route->setPriority($priority);
		return $route;
	}

	/**
	 * Create a new route instance.
	 *
	 * @param  array|string  $methods
	 * @param  string  $uri
	 * @param  mixed   $action
	 * @return \Illuminate\Routing\Route
	 */
	protected function createRoute($methods, $uri, $action)
	{
		$route = parent::createRoute($methods, $uri, $action);
		if ( ! empty($this->groupStack))
		{
			$this->mergePriority($route);
		}
		return $route;
	}

	protected function mergePriority($route)
	{
		$row = last($this->groupStack);
		if (isset($row['priority']))
		{
			$route->setPriority($row['priority']);
		}
	}

	public function dispatch(Request $request)
	{
		$this->getRoutes();
		return parent::dispatch($request);
	}

	public function getRoutes()
	{
		$routes = parent::getRoutes();
		$routes->buildRoutesOrder();
		return $routes;
	}


}