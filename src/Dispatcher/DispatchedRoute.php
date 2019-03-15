<?php
/**
 * Class DispatchedRoute
 *
 * @filesource   DispatchedRoute.php
 * @created      12.03.2019
 * @package      FastRoute\Dispatcher
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace FastRoute\Dispatcher;

/**
 * @property int        $status         - the route status, one of the DispatcherInterface constants
 * @property mixed      $handler        - holds the route handler if FOUND
 * @property array      $arguments      - an array of the supplied argument matches
 * @property array|null $allowedMethods - holds an array with allowed methods in case of a METHOD_NOT_ALLOWED
 */
class DispatchedRoute{

	/** @var int */
	protected $status;

	/** @var mixed */
	protected $handler;

	/** @var array */
	protected $arguments;

	/** @var array|null */
	protected $allowed;

	public function __construct(int $status, $handler = null, array $arguments = null, array $allowed = null){
		$this->status         = $status;
		$this->handler        = $handler;
		$this->arguments      = $arguments ?? [];
		$this->allowedMethods = $allowed;
	}

	/**
	 * Make the values effectively immutable
	 *
	 * @param string $property
	 *
	 * @return mixed|null
	 */
	public function __get(string $property){

		if(\property_exists($this, $property)){
			return $this->{$property};
		}

		return null;
	}

}
