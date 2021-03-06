<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Test;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
            
            ->add('username', TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Enter Username',
                ]
            ])
            ->add('roles', CollectionType::class, [
                // each entry in the array will be an "email" field
                // 'entry_type' => ArrayType::class,
                // these options are passed to each "email" type
                
            ])
             // this is the embeded form, the most important things are highlighted at the bottom
             ->add('exp', CollectionType::class, [
                'entry_type' => ExpType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                // this allows the creation of new forms and the prototype too
                'allow_add' => true,
                // self explanatory, this one allows the form to be removed
                'allow_delete' => true
                
            ])
            ->add('address',  EntityType::class,[
                'class'=> Address::class
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
