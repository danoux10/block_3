<?php

namespace App\Form;

use App\Entity\Owner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
							'label'=>'Nom',
	            'attr'=>[
								'placeholder' =>'john',
	            ],
            ])
            ->add('lastname', TextType::class,[
	            'label'=>'Prénom',
	            'attr'=>[
		            'placeholder' =>'doe',
	            ],
            ])
            ->add('email', EmailType::class,[
	            'label'=>'Email',
	            'attr'=>[
		            'placeholder' =>'johnDoe@exemple.com',
	            ],
            ])
            ->add('adress', TextType::class,[
	            'label'=>'Adresse',
	            'attr'=>[
		            'placeholder' =>'8 rue des citrouilles',
	            ],
            ])
            ->add('phone', TextType::class,[
	            'label'=>'Téléphone',
	            'attr'=>[
		            'placeholder' =>'0612314259',
	            ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Owner::class,
        ]);
    }
}
