<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Teacher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $form = $this -> createFormBuilder()
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
            ])
            -> add('register',SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ]
            ])
            -> getForm();

        $form -> handleRequest($request);

        if($form->isSubmitted()){
            $data = $form->getData();

            $user= new Student();
            $user ->setEmail($data['email']);
            $user ->setFirstname($data['firstname']);
            $user ->setLastname($data['lastname']);
            $user -> setPassword(
                $passwordEncoder->encodePassword($user, $data['password'])
            );

            $em = $this ->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form-> createView()

        ]);
    }

    /**
     * @Route("/teacherRegister", name="teacherRegister")
     */
    public function teacherRegister(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $form = $this -> createFormBuilder()
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('title')
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
            ])
            -> add('register',SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ]
            ])
            -> getForm();

        $form -> handleRequest($request);

        if($form->isSubmitted()){
            $data = $form->getData();

            $user= new Teacher();
            $user ->setEmail($data['email']);
            $user ->setFirstname($data['firstname']);
            $user ->setLastname($data['lastname']);
            $user ->setTitle($data['title']);
            $user -> setPassword(
                $passwordEncoder->encodePassword($user, $data['password'])
            );

            $em = $this ->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_teacherLogin'));
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form-> createView()

        ]);


    }
}
