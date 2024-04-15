<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Contract;
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
            ->add('Apartment', EntityType::class, [
                'class' => Apartment::class,
                'choice_label' => 'id',
            ])
            ->add('Tenant', EntityType::class, [
                'class' => Tenant::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
