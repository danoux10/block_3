<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Contract;
use App\Entity\PaymentType;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('start_at', null, [
				'widget' => 'single_text',
			])
			->add('end_at', null, [
				'widget' => 'single_text',
			])
			->add('apartment', EntityType::class, [
				'class' => Apartment::class,
				'choice_label' => 'address',
				'data'=>$options['apartment'],
			])
			->add('tenant', EntityType::class, [
				'class' => Tenant::class,
				'choice_label' => 'email',
				'data'=>$options['tenant'],
			])
			->add('typePayment', EntityType::class, [
				'class' => PaymentType::class,
				'choice_label' => 'name',
			]);
	}
	
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Contract::class,
			'apartment' => null,
			'tenant'=>null,
		]);
	}
}
