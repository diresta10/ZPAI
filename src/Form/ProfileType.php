<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('email', TextType::class,[
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            -> add('firstname', TextType::class,[
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            -> add('lastname', TextType::class,[
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            -> add('imageFile', FileType::class,[
                'mapped' => false,
                'label' => 'Please upload you image'
            ])

            -> add('register',SubmitType::class,[
                'label' =>'Update',
                'attr' => [
                    'class' => 'btn btn-success float-right']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
