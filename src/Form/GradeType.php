<?php

namespace App\Form;

use App\Entity\Grade;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\GradeCategory',
                'placeholder' => 'Wybierz kategorie',
                'mapped' => false,
                'label' => 'Kategoria',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('gc')
                        -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'gc.classes = c')
                        -> where('c.id='.$options['classesId'])
                        -> andWhere('gc.category_name NOT LIKE :searchTerm')
                        -> setParameter('searchTerm', 'Ocena końcowa');
                }
            ])
            -> add('grade', ChoiceType::class,[
                'label' => 'Ocena',
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
            'data_class' => Grade::class,
            'classesId' => null
        ]);
        $resolver->setAllowedTypes('classesId', 'string');
    }
}
