<?php


namespace App\Controller;

use App\Entity\Notice;
use App\Repository\NoticeRepository;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NoticeController extends AbstractController
{
    /**
     * @Route("/teacherHomepage/notice", name="new_notice")
     * Method({"GET", "POST"})
     */


    public function new(Request $request){

        $form = $this->createFormBuilder()
            -> add('title', TextType::class,[
                'attr'=>[
                    'class' => 'form-control'
                ]
            ])
            -> add('body', TextareaType::class, array(
                'required'=>false,
                'attr' =>array('class'=>'form-control')
            ))
            -> add('register',SubmitType::class,[
                'label' =>'Create',
                'attr' => [
                    'class' => 'btn btn-success float-right']])
            ->getForm();

        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $user_id=$this->get('security.token_storage')->getToken()->getUser();

            $notice= new Notice();
            $notice ->setTitle($data['title']);
            $notice->setBody($data['body']);
            $notice->setTeacher($user_id);
            $notice ->setCreated(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notice);
            $entityManager ->flush();

            return $this->redirectToRoute('teacherHomepage');
        }

        return $this->render('pages/newnotice.html.twig', ['form'=>$form->createView()]);

    }
    /**
     * @Route("/teacherHomepage/mynotice", name="my_notice")
     * @param NoticeRepository $noticeRepository
     * Method({"GET"})
     */
    public function mynotices(NoticeRepository $noticeRepository){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $articles = $noticeRepository ->findMyNotice($userId);

        return $this -> render('pages/mynotices.html.twig', ['articles' => $articles]);
    }
    /**
     * @Route("/teacherHomepage/mynotice/{id}", name="notice_show")
     */

    public function show($id){}

}