<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Owner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApartOwnerType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('Owner', EntityType::class, [
				'class' => Owner::class,
				'choice_label' => 'email',
				'multiple' => true,
				'expanded'=>true,
			]);
	}
	
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Apartment::class,
		]);
	}
}
