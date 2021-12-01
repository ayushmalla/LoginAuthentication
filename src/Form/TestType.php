<?php

namespace App\Form;

use App\Entity\Test;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
            ->add('username')
            ->add('roles', CollectionType::class, [
                // each entry in the array will be an "email" field
                // 'entry_type' => ArrayType::class,
                // these options are passed to each "email" type
                
            ])
                ->add('password', RepeatedType::class, [
                    'type'=> PasswordType::class,
                    'required'=> true,
                    'first_options'=>['label' =>'Password'],
                    'second_options'=> ['label'=>'Confirm Password']
                ])
                ->add('register', SubmitType::class,[
                    'attr'=>[
                        'class' => 'btn btn-success float-left'
                    ]
                    ]);
                    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
