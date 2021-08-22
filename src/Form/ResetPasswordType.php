<?php


namespace App\Form;

use App\Entity\Student;
use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ResetPasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options ){


        $builder
            ->add('oldPassword', PasswordType::class,[
                'mapped' => false,
                'label' => 'Poprzednie hasło',
                'invalid_message' => 'Poprzednie hasło jest niepoprawne',
                ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options'  => array('label' => 'Nowe Hasło'),
                'second_options' => array('label' => 'Powtórz nowe hasło'),
                'required' => true,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults([
            'data_class' => Teacher::class,
        ]);
    }

}