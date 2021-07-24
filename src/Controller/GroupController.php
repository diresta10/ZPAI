<?php
namespace App\Controller;

use App\Entity\Notice;
use App\Entity\Sgroup;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Form\GroupType;
use App\Form\ProfileType;
use App\Form\StudentType;
use App\Repository\GroupRepository;
use App\Repository\NoticeRepository;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;

class GroupController extends AbstractController{

    /**
     * @var GroupRepository
     * @var StudentRepository
     */

    private $groupRepository;
    private $studentrepository;

    public function __construct(GroupRepository $groupRepository, StudentRepository $studentRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->studentrepository = $studentRepository;
    }
    /**
     * @Route("/teacherHomepage/students/download", name="download_students_data")
     * Method({"GET", "POST"})
     */
    public function studentDataDownload(Request $request){

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' =>FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $students = $this -> studentrepository ->findStudentToDownload($userId);

        $html = $this->renderView('pages/download.html.twig',
            ['students' => $students]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fichier = 'students-data-' . $this->getUser()->getId() .'pdf';

        $dompdf->stream($fichier,[
            'Attachment' => true
        ]);

        return new Response();

    }

    /**
     * @Route("/teacherHomepage/students", name="show_students")
     * Method({"GET", "POST"})
     */
    public function showstudents(Request $request){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $profile =$this ->getDoctrine()-> getRepository(Teacher::Class)->find($userId);
        $form2 = $this -> createForm(StudentType::class, $profile);

        if($form2-> handleRequest($request)->isSubmitted() && $form2->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $request -> files -> get('student')['files'];
            $uploads_directory = $this -> getParameter('uploads_directory_2');
            $filename = md5(uniqid())  . '.' . $file-> guessExtension();
            $file -> move(
                $uploads_directory,
                $filename
            );

            //echo "<pre>";
            //var_dump($file); die;
            $profile -> setFiles($filename);

            $entityManager -> persist($profile);
            $entityManager ->flush();

        }

        $group = new Sgroup();
        $form = $this -> createForm(GroupType::class, $group);
        $students = [];

        if($form-> handleRequest($request)->isSubmitted() && $form->isValid()){
            $group = $form -> get('group') -> getData() -> getGroupName();
            $groupId = $form -> get('group') -> getData() -> getId();
            $students = $this -> studentrepository ->findAllStudents($groupId);

            //dd($students);
            //echo "<pre>";
            //var_dump(%kernel.project_dir%); die;

        }
        return $this->render('pages/showstudents.html.twig', ['form'=>$form->createView(),
            'form2' => $form2->createView(),
            'students' => $students, 'groupName'=> $group]);
    }

}

