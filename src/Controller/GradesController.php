<?php
namespace App\Controller;


use App\Entity\Classes;
use App\Entity\Sgroup;
use App\Entity\Student;
use App\Entity\Subject;
use App\Form\GradeType;
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
     * @Route("/teacherHomepage/studentsgrades", name="studentsgrades")
     */
    public function studentsgrades(Request $request)
    {
        $students = $this->studentRepository -> findAllStudents(1);

        $student = new Student();
        $form = $this -> createForm(GradeType::class, $student);

        return $this -> render('pages/grades/studentsgrades.html.twig', ['form'=>$form->createView(),'students'=> $students]);
    }

    /**
     * @Route("/teacherHomepage/test", name="test")
     */
    public function test(Request $request)
    {
        return $this -> render('pages/grades/test.html.twig');
    }

    /**
     * Method({"GET", "POST"})
     * @Route("/teacherHomepage/studentsgrades/edit/{id}", name="studentsgrades_edit")
     */
    public function editstudentsgrades(Request $request, $id)
    {
        $student = $this->studentRepository -> find($id);

        $form = $this -> createForm(GradeType::class, $student);

        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager ->flush();

            return $this->redirectToRoute('studentsgrades');
        }

        return $this->render('pages/grades/editgrade.html.twig', ['form'=>$form->createView()]);
    }


    /**
     * @Route("/teacherHomepage/grades", name="grades")
     */
    public function grades(Request $request)
    {
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $subject = new Classes();
        $form = $this -> createForm(SubjectType::class, $subject, ['userId'=>$userId]);
        $groups = [];
        $students = [];

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $groupId = $form -> get('group') -> getData() -> getId();
            $subjectId = $form -> get('subject') -> getData() -> getId();
            echo "<pre>";
            var_dump($subjectId);
            var_dump($groupId);
            die;
            #$groupId = $this -> groupRepository ->findGroupsBySubject($subjectId);

            #$students = $this -> studentRepository ->findStudentsByGroup($subjectId);

            //dd($students);
            //echo "<pre>";
            //var_dump($groups); die;
            //return $this->redirectToRoute('show_students', array('students' => $students));

        }

        return $this -> render('pages/grades/grades.html.twig', ['form'=>$form->createView(),
            'groups' => $groups, 'students' => $students]);
    }



}

