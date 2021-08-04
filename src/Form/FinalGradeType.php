<?php

namespace App\Form;

use App\Entity\Grade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinalGradeType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('grade', ChoiceType::class,[
                'choices' => array(
                    '2.0' => 2.0,
                    '3.0' => 3.0,
                    '3.5' => 3.5,
                    '4.0' => 4.0,
                    '4.5' => 4.5,
                    '5.0' => 5.0
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grade::class
        ]);
    }
}
