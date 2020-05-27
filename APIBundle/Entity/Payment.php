<?php
/**
 * Created by:
 * User: svetlanakartysh
 * Date: 27.05.2020
 */

namespace App\APIBundle\Entity;
use App\PortalBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Table(name="Payment")
 * @ORM\Entity(repositoryClass="App\APIBundle\Entity\Repo\PaymentRepository")
 */
class Payment
{

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=512)
	 */
	private $currencyFrom;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=512)
	 */
	private $currencyTo;

	/**
	 * @var float
	 * @ORM\Column(type="decimal", precision=8, scale=2)
	 */
	private $price;

	/**
	 * @var integer
	 * @ORM\Column(type="integer")
	 */
	private $amount;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="App\PortalBundle\Entity\User", inversedBy="id", cascade={"persist"})
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", nullable = true)
	 */
	private $active;


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getCurrencyFrom()
	{
		return $this->currencyFrom;
	}

	/**
	 * @param string $currencyFrom
	 */
	public function setCurrencyFrom($currencyFrom)
	{
		$this->currencyFrom = $currencyFrom;
	}

	/**
	 * @return string
	 */
	public function getCurrencyTo()
	{
		return $this->currencyTo;
	}

	/**
	 * @param string $currencyTo
	 */
	public function setCurrencyTo($currencyTo)
	{
		$this->currencyTo = $currencyTo;
	}

	/**
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}

	/**
	 * @return integer
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param integer $amount
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}

	/**
	 * @return bool
	 */
	public function isActive()
	{
		return $this->active;
	}

	/**
	 * @param bool $active
	 */
	public function setActive($active)
	{
		$this->active = $active;
	}
}