<?php

namespace App\Form;

use App\Entity\apartment;
use App\Entity\Contract;
use App\Entity\tenant;
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
                'class' => apartment::class,
                'choice_label' => 'adress',
                'multiple' => true,
            ])
            ->add('tenant', EntityType::class, [
                'class' => tenant::class,
                'choice_label' => 'email',
                'multiple' => true,
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
