<?php

namespace FastRoute\Dispatcher;

use function FastRoute\catch_preg_error;

class DispatcherCharCountBased extends DispatcherAbstract{

	protected function dispatchVariableRoute(array $routeData, string $uri):DispatchedRoute{

		foreach($routeData as $data){
			$preg_match = \preg_match($data['regex'], $uri.$data['suffix'], $matches);
			catch_preg_error(__METHOD__, $data['regex'], $uri.$data['suffix']);

			if(!$preg_match){
				continue;
			}

			[$handler, $varNames] = $data['routeMap'][end($matches)];

			$vars = [];
			$i    = 0;

			foreach($varNames as $varName){
				$vars[$varName] = $matches[++$i];
			}

			return new DispatchedRoute(self::FOUND, $handler, $vars);
		}

		return new DispatchedRoute(self::NOT_FOUND);
	}

}
