<?php
namespace App\Controller;

use App\Entity\Notice;
use App\Entity\Student;
use App\Form\ProfileType;
use App\Repository\NoticeRepository;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController{

    /**
     * @var NoticeRepository
     * @var StudentRepository
     */

    private $noticeRepository;
    private $studentRepository;

    public function __construct(NoticeRepository $noticeRepository, StudentRepository $studentRepository)
    {
        $this->noticeRepository = $noticeRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function index(){

        $articles = $this->noticeRepository -> findPublishedNotice();
        return $this -> render('pages/teacherHomepage.html.twig', array ('articles' => $articles));
    }

    /**
     * @Route("/", name="welcome")
     */
    public function welcome(){
        return $this->render('pages/welcome.html.twig');
    }

    /**
     * @Route("/homepage/profile", name="edit_profile")
     * Method({"GET", "POST"})
     */
    public function profile(Request $request){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $profile =$this ->getDoctrine()-> getRepository(Student::Class)->find($userId);
        $form = $this -> createForm(ProfileType::class, $profile);

        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $request -> files -> get('profile')['imageFile'];
            $uploads_directory = $this -> getParameter('uploads_directory');
            $filename = md5(uniqid())  . '.' . $file-> guessExtension();
            $file -> move(
                $uploads_directory,
                $filename
            );

            //echo "<pre>";
            //var_dump($file); die;
            $profile -> setImage ($filename);

            $entityManager -> persist($profile);
            $entityManager ->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('pages/profile.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/homepage/myprofile", name="my_profile")
     * Method({"GET"})
     */
    public function myprofile(Request $request){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $this -> studentRepository ->findStudentInfo($userId);
        //echo "<pre>";
        //var_dump($user); die;

        return $this->render('pages/myprofile.html.twig', ['user'=>$user]);
    }

    /**
     * @Route("/homepage/grades", name="students_grades")
     * Method({"GET"})
     */
    public function grades(Request $request){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $this -> studentRepository ->findStudentInfo($userId);
        //echo "<pre>";
        //var_dump($user); die;

        return $this->render('pages/studentGrades.html.twig', ['user'=>$user]);
    }

}

