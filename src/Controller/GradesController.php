<?php
namespace App\Controller;


use App\Entity\Classes;
use App\Entity\Grade;
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

        $students = $this -> studentRepository ->findAllStudents($groupId);
        $categories = $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findGradeCategory($groupId, $subjectId);
        $grades =  $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findGrades($groupId, $subjectId);


        #echo "<pre>";
        #var_dump($students);
        #var_dump($categories[0]);
        #var_dump($grades);
        #die;

        return $this -> render('pages/grades/studentsgrades.html.twig', ['students'=> $students, 'categories'=> $categories, 'grades' => $grades,
            'groupId' => $groupId, 'subjectId' => $subjectId]);
    }

    /**
     * @Route("/teacherHomepage/test", name="test")
     */
    public function test(Request $request)
    {
        return $this -> render('pages/grades/test.html.twig');
    }


    /**
     * @Route("/teacherHomepage/grades/{groupId}/{subjectId}/{id}/edit", name="studentsgrades_edit")
     */
    public function editstudentsgrades(Request $request, $groupId, $subjectId, $id)
    {

        $grade = new Grade();
        $form = $this -> createForm(GradeType::class, $grade, ['subjectId'=>$subjectId, 'groupId'=>$groupId]);
        $form->handleRequest($request);

        $em = $this ->getDoctrine()->getManager();
        $user = $em ->getRepository(Student::class) ->find((int)$id);

        #echo "<pre>";
        #var_dump($user);
        #var_dump($categories[0]);
        #var_dump($grades);
        #die;


        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $category = $form->get('category')->getData();
            $grade = $form->get('grade')->getData();


            //Ids do spradzenia czy ocena już istnieje
            $classesId = $this->getDoctrine()->getRepository(Grade::class)->findClasses($groupId, $subjectId);
            $categoryId = $category->getId();
            $gradeId = $this->getDoctrine()->getRepository(Grade::class)->findGrade($categoryId, (int)$id, $classesId[0]['id']);

            //sprawdzam czy ocena isnieje
            if ($gradeId) {
                $grade_edit = $this->getDoctrine()->getRepository(Grade::Class)->find($gradeId[0]['id']);
                $grade_edit->setGrade($grade);
                $em->persist($grade_edit);
                $em->flush();

            } else {

                $classes = $em->getRepository(Classes::class)->find($classesId[0]['id']);
                $notice = new Grade();
                $notice->setCategory($category);
                $notice->setGrade($grade);
                $notice->setClasses($classes);
                $notice->setStudent($user);
                $notice->setDate(new \DateTime());

                $em->persist($notice);
                $em->flush();


            }
            return $this->redirectToRoute('studentsgrades', array('groupId' => $groupId, 'subjectId' => $subjectId));

        }
        return $this->render('pages/grades/addgrade.html.twig', ['form'=>$form->createView() , 'id' => $id , 'user' => $user]);
    }


    /**
     * @Route("/teacherHomepage/grades", name="grades")
     */
    public function grades(Request $request)
    {
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $classes = new Classes();
        $form = $this -> createForm(SubjectType::class, $classes, ['userId'=>$userId]);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $groupId = $form -> get('group') -> getData() -> getId();
            $subjectId = $form -> get('subject') -> getData() -> getId();


            return $this->redirectToRoute('studentsgrades', array('groupId' => $groupId, 'subjectId' => $subjectId));

        }

        return $this -> render('pages/grades/grades.html.twig', ['form'=>$form->createView()]);
    }



}

