<?php


namespace App\Form;

use App\Entity\Sgroup;
use App\Entity\Notice;
use App\Entity\Teacher;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options ){


        $builder
            -> add('files', FileType::class,[
                'mapped' => false,
                'label' => 'Import CSV file with students'
            ])

            -> add('register',SubmitType::class,[
                'label' =>'Edytuj',
                'attr' => [
                    'class' => 'btn btn-success float-right']])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults([
            'data_class' => Teacher::class,
        ]);
    }

}