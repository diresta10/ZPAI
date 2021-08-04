<?php
namespace App\Controller;

use App\Entity\Notice;
use App\Entity\Sgroup;
use App\Entity\Teacher;
use App\Form\NoticeFormType;
use App\Form\ProfileType;
use App\Form\StudentType;
use App\Repository\NoticeRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Flex\Response;

class TeacherController extends AbstractController
{
    /**
     * @var NoticeRepository
     */

    private $noticeRepository;

    public function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * @Route("/teacherHomepage", name="teacherHomepage"))
     */

    public function teacherHomepage(){

        $articles = $this->noticeRepository -> findPublishedNotice();
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();

        $students =$this ->getDoctrine()-> getRepository(Teacher::Class) -> findStudentsNumber($userId);
        $studentsNumber = $students[0][1];

        $groups =$this ->getDoctrine()-> getRepository(Teacher::Class) -> findGroupsNumber($userId);
        $groupsNumber = $groups[0][1];

        $subjects =$this ->getDoctrine()-> getRepository(Teacher::Class) -> findSubjectsNumber($userId);
        $subjectsNumber = $subjects[0][1];

        #echo "<pre>";
        #var_dump($subjects);
        #die;

        return $this -> render('pages/tHomepage.html.twig', ['articles' => $articles,
            'studentsNumber' => $studentsNumber, 'groupsNumber' => $groupsNumber, 'subjectsNumber' => $subjectsNumber]);
    }



    /**
     * @Route("/teacherHomepage/profile", name="teacherProfile")
     * Method({"GET", "POST"})
     */
    public function profile(Request $request){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $profile =$this ->getDoctrine()-> getRepository(Teacher::Class)->find($userId);
        $form = $this -> createForm(ProfileType::class, $profile);


        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager ->flush();

            return $this->redirectToRoute('teacherHomepage');
        }

        return $this->render('pages/profile.html.twig', ['form'=>$form->createView()]);
    }



}

