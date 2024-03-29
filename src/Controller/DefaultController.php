<?php
namespace App\Controller;

use App\Entity\Notice;
use App\Entity\Student;
use App\Form\ProfileType;
use App\Repository\NoticeRepository;
use App\Repository\StudentRepository;
use App\Services\FileUploader;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        return $this -> render('index.html.twig', array ('articles' => $articles));
    }

    /**
     * @Route("/", name="welcome")
     */
    public function welcome(){
        return $this->render('welcome.html.twig');
    }

    /**
     * @Route("/homepage/profile", name="edit_profile")
     * Method({"GET", "POST"})
     */
    public function profile(Request $request, FileUploader $fileUploader, TranslatorInterface $translator){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $profile =$this ->getDoctrine()-> getRepository(Student::Class)->find($userId);
        $form = $this -> createForm(ProfileType::class, $profile);

        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $request -> files -> get('profile')['imageFile'];

            if($file){

                $uploads_directory = $this -> getParameter('uploads_directory');
                $filename = $fileUploader ->uploadFile($file);

                $profile -> setImage ($filename);
                $entityManager -> persist($profile);
                $entityManager ->flush();

                $message = $translator->trans('Edycja profilu powiodła się');

                $this->addFlash('info', $message);
            }

            //echo "<pre>";
            //var_dump($file); die;
            return $this->redirectToRoute('edit_profile');
        }

        return $this->render('profile/profile.html.twig', ['form'=>$form->createView()]);
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

        return $this->render('profile/myprofile.html.twig', ['user'=>$user]);
    }

    /**
     * @Route("/homepage/myprofile/download/{file}", name="file_download")
     * Method({"GET"})
     */
    public function downloadfile(Request $request, $file){

        //echo "<pre>";
        //var_dump($file); die;
        $displayName = 'image-data-' . $this->getUser()->getId() .'.jpg';
        $file_with_path = $this->getParameter ( 'uploads_directory' ) . "/" . $file;
        $response = new BinaryFileResponse ( $file_with_path );
        $response->headers->set ( 'Content-Type', 'text/plain' );
        $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $displayName );
        return $response;

    }



}

