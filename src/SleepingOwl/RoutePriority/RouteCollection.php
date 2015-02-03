<?php namespace SleepingOwl\RoutePriority;

use Illuminate\Routing\RouteCollection as IlluminateRouteCollection;

class RouteCollection extends IlluminateRouteCollection
{

	/**
	 * @var \Closure
	 */
	protected $cmpFunction;

	function __construct()
	{
		$this->cmpFunction = function ($route1, $route2)
		{
			$a = $route1->getPriority();
			$b = $route2->getPriority();

			if ($a == $b)
			{
				return 0;
			}
			return ($a < $b) ? 1 : -1;
		};
	}


	/**
	 * Add the given route to the arrays of routes.
	 *
	 * @param  \Illuminate\Routing\Route $route
	 * @return void
	 */
	protected function addToCollections($route)
	{
		$domainAndUri = $route->domain() . $route->getUri();

		foreach ($route->methods() as $method)
		{
			$this->routes[$method][$domainAndUri] = $route;
		}

		$this->allRoutes[$method . $domainAndUri] = $route;
	}

	public function buildRoutesOrder()
	{
		uasort($this->allRoutes, $this->cmpFunction);
		foreach ($this->routes as $method => $_tmp)
		{
			uasort($this->routes[$method], $this->cmpFunction);
		}
	}

} 