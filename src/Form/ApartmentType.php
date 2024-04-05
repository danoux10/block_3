<?php

namespace App\Form;

use App\Entity\Apartment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', NumberType::class,[
							'label'=>'Code postal',
	            'attr'=>[
								'placeholder' => '10000',
	            ],
            ])
            ->add('city', TextType::class,[
							'label'=>'Ville',
	            'attr'=>[
								'placeholder' => 'Troyes',
	            ],
            ],)
            ->add('adress',TextType::class,[
							'label'=>'Adresse',
	            'attr'=>[
								'placeholder'=>'8 rue des coquelicot',
	            ]
            ],)
            ->add('guarantee', TextType::class,[
							'label'=>'Garantie',
	            'attr'=>[
								'placeholder'=>'120.20',
	            ],
            ],)
            ->add('charge',TextType::class,[
	            'label'=>'Charge',
	            'attr'=>[
		            'placeholder'=>'1200.20',
	            ],
            ],)
            ->add('rent',TextType::class,[
	            'label'=>'Loyer',
	            'attr'=>[
		            'placeholder'=>'3000',
	            ],
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
