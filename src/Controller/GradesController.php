<?php
namespace App\Controller;


use App\Entity\Sgroup;
use App\Entity\Subject;
use App\Form\GroupBySubjectType;
use App\Form\SubjectType;
use App\Repository\GradeRepository;
use App\Repository\GroupRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GradesController extends AbstractController{

    /**
     * @var StudentRepository
     * @var GroupRepository
     */

    private $studentRepository;
    private $groupRepository;


    public function __construct(StudentRepository $studentRepository, GroupRepository $groupRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @Route("/teacherHomepage/grades", name="grades")
     */
    public function grades(Request $request)
    {
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $subject = new Subject();
        $form = $this -> createForm(SubjectType::class, $subject, ['userId'=>$userId]);
        $groups = [];
        $students = [];

        if($form-> handleRequest($request)->isSubmitted() && $form->isValid()){

            #$subjectId = $form -> get('group_name') -> getData() -> getId();
            #echo "<pre>";
            #var_dump($subjectId); die;
            #$groups = $this -> groupRepository ->findGroupsBySubject($subjectId);

            #$students = $this -> studentRepository ->findStudentsByGroup($subjectId);

            //dd($students);
            //echo "<pre>";
            //var_dump($groups); die;
            //return $this->redirectToRoute('show_students', array('students' => $students));

        }

        return $this -> render('pages/grades.html.twig', ['form'=>$form->createView(),
            'groups' => $groups, 'students' => $students]);
    }



}

