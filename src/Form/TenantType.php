<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Contract;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('lastname')
            ->add('email')
            ->add('adress')
            ->add('phone')
            ->add('apl_value')
            ->add('apl')
            ->add('apartments', EntityType::class, [
                'class' => Apartment::class,
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
            'data_class' => Tenant::class,
        ]);
    }
}
