<?php
/**
 * Created by:
 * User: svetlanakartysh
 * Date: 27.05.2020
 */

namespace App\Admin;

use App\PortalBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PaymentAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper->add('currencyFrom', TextType::class);
		$formMapper->add('currencyTo', TextType::class);
		$formMapper->add('user', EntityType::class,
			['class'        => User::class,
			 'choice_label' => 'name']);
		$formMapper->add('amount', IntegerType::class);
		$formMapper->add('price', IntegerType::class);
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('currencyFrom');
		$datagridMapper->add('currencyTo');
//		$datagridMapper->add('user');
		$datagridMapper->add('amount');
		$datagridMapper->add('price');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('currencyFrom');
		$listMapper->addIdentifier('currencyTo');
//		$listMapper->addIdentifier('user');
		$listMapper->addIdentifier('amount');
		$listMapper->addIdentifier('price');
	}
}