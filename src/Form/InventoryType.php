<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Inventory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('created_at', DateType::class, [
				'label'=>'Fait le',
				'widget' => 'single_text',
			])
			->add('remark', TextareaType::class,[
				'label'=>'remarque',
			])
		
			->add('Apartment', EntityType::class, [
				'class' => Apartment::class,
				'choice_label' => 'id',
				'data'=>$options['apartment'],
			]);
	}
	
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Inventory::class,
			'apartment' => null,
		]);
	}
}
