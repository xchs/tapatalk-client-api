<?php

namespace Netzmacht\Tapatalk\Api\Exception;

use Exception;
use Netzmacht\Tapatalk\Util\Value;

class InvalidResponseException extends \Exception
{
	/**
	 * @var string
	 */
	private $responseError;

	/**
	 * @param string| $responseError
	 * @param string $message
	 * @param int $code
	 * @param Exception $previous
	 */
	public function __construct($message = '', $responseError='', $code = 0, Exception $previous = null)
	{
		if($responseError) {
			$responseError = Value::deserialize($responseError);
			$message       = sprintf($message, $responseError);
		}

		parent::__construct($message, $code, $previous);

		$this->responseError = $responseError;
	}


	/**
	 * @return string
	 */
	public function getResponseError()
	{
		return $this->responseError;
	}

} 