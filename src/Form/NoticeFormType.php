<?php

namespace App\Form;

use App\Entity\Notice;
use App\Entity\Sgroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'label' => 'Tytul',
                'attr'=>[
                    'class' => 'form-control',

                ]
            ])
            -> add('body', TextareaType::class, array(
                'required'=>false,
                'label' => 'Treść',
                'attr' =>array('class'=>'form-control')
            ))
            ->add('grupa', EntityType::class,[
                'class' => Sgroup::class,
                'mapped' => false,
                'choice_label' => function(Sgroup $group){
                    return $group-> getGroupName();
                }])
            -> add('register',SubmitType::class,[
                'label' =>'Zapisz',
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
