<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Contract;
use App\Entity\owner;
use App\Entity\tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('city')
            ->add('adress')
            ->add('guarantee')
            ->add('charge')
            ->add('rent')
            ->add('owner', EntityType::class, [
                'class' => owner::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('tenant', EntityType::class, [
                'class' => tenant::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('contracts', EntityType::class, [
                'class' => Contract::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apartment::class,
        ]);
    }
}
