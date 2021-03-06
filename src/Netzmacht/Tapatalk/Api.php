<?php

/**
 * @package    tapatalk-client-api
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Tapatalk;


use Netzmacht\Tapatalk\Api\Config;
use Netzmacht\Tapatalk\Assertion;

/**
 * Class Api
 * @package Netzmacht\Tapatalk
 */
abstract class Api
{
	/**
	 * @var Assertion
	 */
	private $assertion;

	/**
	 * @var Transport
	 */
	protected $transport;

	/**
	 * @var Config
	 */
	protected $config;


	/**
	 * @param Transport $transport
	 * @param Api\Config $config
	 */
	function __construct(Transport $transport, Config $config)
	{
		$this->transport = $transport;
		$this->config    = $config;
	}


	/**
	 * @return Assertion
	 */
	protected function assert()
	{
		if(!$this->assertion) {
			$this->assertion = new Assertion($this->config);
		}

		return $this->assertion;
	}

} 