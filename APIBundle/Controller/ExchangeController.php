<?php
/**
 * Created by:
 * User: svetlanakartysh
 * Date: 26.05.2020
 */

namespace App\APIBundle\Controller;


use App\APIBundle\Entity\Payment;
use App\PortalBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpClient\HttpClient;
use Binance;

/**
 * @Route("/exchange")
 */
class ExchangeController extends Controller
{
	/**
	 *
	 * @Route("/", name="api_exchange")
	 */
	public function indexAction()
	{

		return $this->render('@API/Exchange/index.html.twig', [
			'trade' => $this->get('service.api.binance')->getTrade('BTCUSDC'),
		]);
	}


	/**
	 * Результат произведенного обмена валют
	 *
	 * @Route("/result", name="api_exchange_result")
	 * @Method("POST")
	 */
	public function resultAction(Request $request)
	{
		if (!$request->get('amount') or
			!$request->get('from') or
			!$request->get('to')
		) {
			throw new BadRequestHttpException('Неверные параметры');
		}

		$trade = $this->get('service.api.binance')->getTrade('BTCUSDC');

		$result = $this->barter(
			(int)$request->get('amount'),
			$request->get('from'),
			$request->get('to'),
			$trade
		);

		return new JsonResponse([
			'status' => 200,
			'result' => $result,
		]);
	}


	/**
	 * Процесс обмена валют
	 *
	 * @param $string $from, $to, $trade
	 * @param $int $amount
	 *
	 * @return $int $result
	 *
	 */
	public function barter($amount, $from, $to, $trade)
	{
		$result = null;
		if ($from == 'USD') {
			$result = ($amount / $trade);
		} elseif ($from == 'BTC') {
			$result = ($amount * $trade);
		}

		return $result;
	}


	/**
	 * Coвершенный платеж
	 *
	 * @Route("/payment", name="api_exchange_payment")
	 * @Method("POST")
	 */
	public function paymentAction(Request $request)
	{
		if (!$request->get('amount') or
			!$request->get('from') or
			!$request->get('to') or
			!$request->get('name') or
			!$request->get('address')
		) {
			throw new BadRequestHttpException('Неверные параметры');
		}

		$doctrine = $this->get('doctrine');
		$em       = $doctrine->getManager();

		$user = $doctrine->getRepository('PortalBundle:User')
			->findOneByName(trim($request->get('name')));

		if (!$user) {
			$user = new User();
			$user->setName($request->get('name'));
			$user->setAddress($request->get('address'));
			$em->persist($user);
			$em->flush($user);
		}

		$payment = new Payment();
		$payment->setUser($user);
		$payment->setPrice((int)$this->get('service.api.binance')->getTrade('BTCUSDC'));
		$payment->setCurrencyFrom($request->get('from'));
		$payment->setCurrencyTo($request->get('to'));
		$payment->setAmount((int)$request->get('amount'));
		$payment->setActive(true);

		$em->persist($payment);
		$em->flush($payment);

		return new JsonResponse([
			'status' => 200,
		]);
	}
}