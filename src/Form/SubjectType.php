<?php


namespace App\Form;


use App\Entity\Sgroup;
use App\Entity\Subject;
use App\Entity\Classes;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubjectType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options )
    {

       // echo "<pre>";
       // var_dump($options['userId']); die;
        $builder
            ->add('group', EntityType::class, [
                'class' => 'App\Entity\Sgroup',
                'placeholder' => 'Select a subject',
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('g')
                        -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'g = s.group')
                        -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'s = c.subject')
                        -> where('c.teacher='.$options['userId']);
                }
            ]);

        $builder->get('group') -> addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event)
            {
                $form = $event->getForm();

                #dump($form->getData());

                $form -> getParent()-> add('subject_name', EntityType::class, [
                    'class' => Subject::class,
                    'placeholder' => 'Please select a sub category',
                    'choices' => $form-> getData() -> getSubjects()
                ]);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults([
            'data_class' => Subject::class,
            'userId' => null
        ]);
        $resolver->setAllowedTypes('userId', 'int');

    }

}