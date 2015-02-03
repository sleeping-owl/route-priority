<?php namespace SleepingOwl\RoutePriority;

use Illuminate\Routing\Route as IlluminateRoute;

class Route extends IlluminateRoute
{

	/**
	 * @var int
	 */
	protected $priority = Router::MEDIUM;

	/**
	 * @return int
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	/**
	 * @param int $priority
	 */
	public function setPriority($priority)
	{
		$this->priority = $priority;
	}

}