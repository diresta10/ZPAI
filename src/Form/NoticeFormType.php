<?php

namespace App\Form;

use App\Entity\Notice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoticeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('title', TextType::class,[
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            -> add('body', TextareaType::class, array(
                'required'=>false,
                'attr' =>array('class'=>'form-control')
            ))
            -> add('register',SubmitType::class,[
                'label' =>'Update',
                'attr' => [
                    'class' => 'btn btn-success float-right']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
