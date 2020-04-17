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
	protected int $status;

	/** @var mixed */
	protected $handler = null;

	/** @var array */
	protected ?array $arguments = null;

	/** @var array|null */
	protected ?array $allowed = null;

	/**
	 * DispatchedRoute constructor.
	 *
	 * @param int        $status
	 * @param mixed|null $handler
	 * @param array|null $arguments
	 * @param array|null $allowedMethods
	 */
	public function __construct(int $status, $handler = null, array $arguments = null, array $allowedMethods = null){
		$this->status         = $status;
		$this->handler        = $handler;
		$this->arguments      = $arguments ?? [];
		$this->allowedMethods = $allowedMethods;
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
