<?php
/**
 * Created by:
 * User: svetlanakartysh
 * Date: 26.05.2020
 */

namespace App\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Binance;

class ApiBinance
{
	private $container;


	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}


	/**
	 * @param string $symbol
	 *
	 * @return string
	 *
	 */
	public function getTrade($symbol)
	{
		$trade = null;

		try {
			/** @var Binance\API $api */
			$api             = new Binance\API($this->container->getParameter('binance_api_key'), $this->container->getParameter('binance_api_secret'));
			$api->caOverride = true;

			$trade = $api->price($symbol);

		} catch (\Exception $e) {
			$msg = 'Произошла ошибка: ' . $e->getMessage();

			return $msg;

		}

		return $trade;
	}
}