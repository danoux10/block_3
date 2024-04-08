<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Contract;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
							'label'=>'Nom',
	            'attr'=>[
								'placeholder' =>'Doe'
	            ],
            ])
            ->add('lastname',TextType::class,[
	            'label'=>'Prénom',
	            'attr'=>[
		            'placeholder' =>'John'
	            ],
            ])
            ->add('email',EmailType::class,[
	            'label'=>'Email',
	            'attr'=>[
		            'placeholder' =>'johnDoe@example.com'
	            ],
            ])
            ->add('adress',TextType::class,[
	            'label'=>'Adresse',
	            'attr'=>[
		            'placeholder' =>'8 rue des fleurs'
	            ],
            ])
            ->add('phone',TextType::class,[
	            'label'=>'Téléphone',
	            'attr'=>[
		            'placeholder' =>'0615243652'
	            ],
            ])
            ->add('apl_value',TextType::class,[
	            'label'=>'Valeur des Apl',
	            'attr'=>[
		            'placeholder' =>''
	            ],
            ])
            ->add('apl', CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tenant::class,
        ]);
    }
}
