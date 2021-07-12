<?php


namespace App\Form;

use App\Entity\Sgroup;
use App\Entity\Notice;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options ){


        $builder
            ->add('group', EntityType::class,[
                'class' => Sgroup::class,
                'mapped' => false,
                'choice_label' => function(Sgroup $group){
                    return $group-> getGroupName();
                }])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults([
            'data_class' => Sgroup::class,
        ]);
    }

}