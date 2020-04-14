<?php

namespace FastRoute\DataGenerator;

class GeneratorCharCountBased extends DataGeneratorAbstract{

	protected int $approxChunkSize = 30;

	protected function processChunk(array $regexToRoutesMap):array{
		$routeMap  = [];
		$regexes   = [];
		$suffixLen = 0;
		$suffix    = '';
		$count     = \count($regexToRoutesMap);

		foreach($regexToRoutesMap as $regex => $route){
			$suffixLen++;
			$suffix .= "\t";

			$regexes[]         = '(?:'.$regex.'/(\t{'.$suffixLen.'})\t{'.($count - $suffixLen).'})';
			$routeMap[$suffix] = [$route->handler, $route->variables];
		}

		return [
			'regex'    => '~^(?|'.\implode('|', $regexes).')$~',
			'suffix'   => '/'.$suffix,
			'routeMap' => $routeMap
		];
	}

}
