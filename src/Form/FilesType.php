<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\File;
use App\Entity\Student;
use App\Entity\Subject;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('file', FileType::class,[
                'mapped' => false,
                'label' => 'Wybierz plik',
            ])
        ;
        $builder
            ->add('group', EntityType::class, [
                'class' => 'App\Entity\Sgroup',
                'placeholder' => 'Wybierz grupę',
                'label' => 'Grupa',
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('g')
                        -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'g = s.group')
                        -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'s = c.subject')
                        -> innerJoin('App\Entity\YearOfStudy','y',\Doctrine\ORM\Query\Expr\Join::WITH,'y = s.year_of_study')
                        -> where('c.teacher='.$options['userId'])
                        -> andwhere('y.isActive=true');
                }
            ]);

        $builder->get('group') -> addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event)
            {
                $form = $event->getForm();

                $form -> getParent()-> add('subject', EntityType::class, [
                    'class' => Subject::class,
                    'placeholder' => 'Wybierz przedmiot',
                    'choices' => $form-> getData() -> getSubjects()
                ]);
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                dump($data);
                $sub_cat = $data->getSubject();


                if ($sub_cat) {
                    $form->get('group')->setData($sub_cat->getGroup());

                    $form->add('subject', EntityType::class, [
                        'class' => Subject::class,
                        'placeholder' => 'Wybierz grupę',
                        'label' => 'Przedmiot',
                        'choices' => $sub_cat->getGroup()->getSubjects()
                    ]);
                } else {
                    $form->add('subject', EntityType::class, [
                        'class' => Subject::class,
                        'placeholder' => 'Wybierz przedmiot',
                        'label' => 'Przedmiot',
                        'choices' => []
                    ]);
                }

            }
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classes::class,
            'userId' => null
        ]);
        $resolver->setAllowedTypes('userId', 'int');
    }
}
