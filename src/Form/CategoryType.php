<?php


namespace App\Form;

use App\Entity\GradeCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options ){


        $builder
            -> add('category_name', TextType::class,[
                'label' => 'Nazwa categorii',
                'attr'=>[
                    'class' => 'form-control'
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults([
            'data_class' => GradeCategory::class,
        ]);
    }

}