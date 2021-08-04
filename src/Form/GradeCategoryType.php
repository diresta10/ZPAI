<?php


namespace App\Form;

use App\Entity\GradeCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeCategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options ){


        $builder
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\GradeCategory',
                'placeholder' => 'Select a category',
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('gc')
                        -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'gc.classes = c')
                        -> where('c.id='.$options['classesId'])
                        -> andWhere('gc.category_name NOT LIKE :searchTerm')
                        -> setParameter('searchTerm', 'Final');
                }
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults([
            'data_class' => GradeCategory::class,
            'classesId' => null
        ]);
        $resolver->setAllowedTypes('classesId', 'string');
    }

}