<?php

namespace FastRoute\Dispatcher;

interface DispatcherInterface{

	const NOT_FOUND          = 0;
	const FOUND              = 1;
	const METHOD_NOT_ALLOWED = 2;

	/**
	 * @param array $data
	 *
	 * @return \FastRoute\Dispatcher\DispatcherInterface
	 */
	public function loadDispatchData(array $data):DispatcherInterface;

	/**
	 * Dispatches against the provided HTTP method verb and URI.
	 *
	 * Returns array with one of the following formats:
	 *
	 *     [self::NOT_FOUND]
	 *     [self::METHOD_NOT_ALLOWED, ['GET', 'OTHER_ALLOWED_METHODS']]
	 *     [self::FOUND, $handler, ['varName' => 'value', ...]]
	 *
	 * @param string $httpMethod
	 * @param string $uri
	 *
	 * @return \FastRoute\Dispatcher\DispatchedRoute
	 */
	public function dispatch(string $httpMethod, string $uri):DispatchedRoute;
}
