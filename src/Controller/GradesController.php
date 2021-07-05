<?php
namespace App\Controller;


use App\Entity\Classes;
use App\Entity\GradeCategory;
use App\Entity\Sgroup;
use App\Entity\Student;
use App\Entity\Subject;
use App\Form\GradeType;
use App\Form\GroupBySubjectType;
use App\Form\SubjectType;
use App\Repository\GradeCategoryRepository;
use App\Repository\GradeRepository;
use App\Repository\GroupRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/teacherHomepage/grades/{groupId}/{subjectId}", name="studentsgrades")
     */
    public function studentsgrades(Request $request, $groupId, $subjectId)
    {
       # $students = $this->studentRepository -> findAllStudents(1);

        $student = new Student();
        $form = $this -> createForm(GradeType::class, $student);
        $students = $this -> studentRepository ->findAllStudents($groupId);
        $categories = $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findGradeCategory($groupId, $subjectId);
        $grades =  $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findGrades($groupId, $subjectId);

        #echo "<pre>";
        #var_dump($students);
        #var_dump($categories[0]);
        #var_dump($grades);
        #die;

        return $this -> render('pages/grades/studentsgrades.html.twig', ['form'=>$form->createView(),'students'=> $students, 'categories'=> $categories, 'grades' => $grades]);
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

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $groupId = $form -> get('group') -> getData() -> getId();
            $subjectId = $form -> get('subject') -> getData() -> getId();

            #$students = $this -> studentRepository ->findAllStudents($groupId);
            #$students = $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findGradeCategory($groupId, $subjectId);


            #echo "<pre>";
            #var_dump($students);
            #var_dump($categories);
            #var_dump($group);
            #die;

            return $this->redirectToRoute('studentsgrades', array('groupId' => $groupId, 'subjectId' => $subjectId));

        }

        return $this -> render('pages/grades/grades.html.twig', ['form'=>$form->createView()]);
    }



}

