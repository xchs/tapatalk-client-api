<?php

namespace Netzmacht\Tapatalk\Api\Search;
use Netzmacht\Tapatalk\Transport\MethodCall;

/**
 * Class AdvancedSearch
 * @package Netzmacht\Tapatalk\Api\Search
 */
class AdvancedSearch
{
	const SEARCH_ID  = 'searchid';

	const USERNAME   = 'searchuser';

	const KEYWORDS   = 'keywords';

	const USER_ID    = 'userid';

	const FORUM_ID   = 'froumid';

	const THREAD_ID  = 'threadid';

	const TITLE_ONLY = 'titleonly';

	const SEARCH_TIME = 'searchtime';

	const ONLY_IN     = 'only_in';

	const NOT_IN      = 'not_in';


	/**
	 * @return array
	 */
	public static function getFilters()
	{
		$reflector = new \ReflectionClass(get_called_class());
		return array_flip(array_values($reflector->getConstants()));
	}


	/**
	 * @param \Netzmacht\Tapatalk\Transport\MethodCall $method
	 * @param array $filters
	 */
	public static function applyFilters(MethodCall $method, array $data)
	{
		$data       = array_intersect_key($data, static::getFilters());
		$filters    = $method->getParam('filters');
		$serializer = $method->getSerializer();

		foreach($data as $name => $filter) {
			switch($name) {
				// serialize value
				case static::USERNAME:
				case static::KEYWORDS:
					$filter = $serializer->serialize($filter);
					break;

				// force string
				case static::SEARCH_ID:
				case static::THREAD_ID:
				case static::FORUM_ID:
					$filter = (string) $filter;
					break;

				// force string for array values
				case static::NOT_IN:
				case static::ONLY_IN:
					$filter = array_map('strval', $filter);
					break;

				// convert datetime to timestamp
				case static::SEARCH_TIME:
					if($filter instanceof \DateTime) {
						$filter = $filter->getTimestamp();
					}

					break;

				// boolean to int
				case static::TITLE_ONLY:
					$filter = $filter ? 1 : 0;
					break;
			}

			$filters[$name] = $filter;
		}

		$method->set('filters', $filters);

		return $filters;
	}

} 