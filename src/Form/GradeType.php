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
                'placeholder' => 'Select a category',
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('gc')
                        -> innerJoin('App\Entity\Grade','g',\Doctrine\ORM\Query\Expr\Join::WITH,'gc = g.category')
                        -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'g.classes = c')
                        -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject = s')
                        -> where('s.id='.$options['subjectId'], 's.group ='.$options['groupId']);
                }
            ])
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
            'data_class' => Grade::class,
            'subjectId' => null,
            'groupId' => null
        ]);
        $resolver->setAllowedTypes('subjectId', 'string');
        $resolver->setAllowedTypes('groupId', 'string');
    }
}
