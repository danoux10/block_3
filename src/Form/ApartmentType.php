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
							'label'=>'code postal',
	            'attr'=>[
								'placeholder' => '10000',
	            ],
            ])
            ->add('city', TextType::class,[
							'label'=>'ville',
	            'attr'=>[
								'placeholder' => 'Troyes',
	            ],
            ],)
            ->add('address',TextType::class,[
							'label'=>'adresse',
	            'attr'=>[
								'placeholder'=>'8 rue des coquelicot',
	            ]
            ],)
            ->add('guarantee', TextType::class,[
							'label'=>'garantie',
	            'attr'=>[
								'placeholder'=>'120.20',
	            ],
            ],)
            ->add('rent',TextType::class,[
	            'label'=>'loyer',
	            'attr'=>[
		            'placeholder'=>'3000',
	            ],
            ])
	        ->add('water', TextType::class,[
						'label'=>'Eaux',
		        'attr'=>[
							'placeholder'=>'1500',
		        ]
	        ])
	        ->add('electricity',TextType::class,[
						'label'=>'électricité',
		        'attr'=>[
			        'placeholder'=>'1500',
		        ]
	        ])
	        ->add('gas',TextType::class,[
		        'label'=>'gaz',
		        'attr'=>[
			        'placeholder'=>'1500',
		        ]
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
