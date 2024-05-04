<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Owner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('city')
            ->add('address')
            ->add('guarantee')
            ->add('rent')
            ->add('water')
            ->add('electricity')
            ->add('gas')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apartment::class,
        ]);
    }
}
