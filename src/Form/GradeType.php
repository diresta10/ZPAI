<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('firstname', TextType::class,[
                'attr'=>[
                    'class' => 'form-control',
                    'readonly' => 'true'
                ]
            ])
            -> add('lastname', TextType::class,[
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            -> add('email', TextType::class,[
                'attr'=>[
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
