<?php
namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Grade;
use App\Entity\GradeCategory;
use App\Entity\Sgroup;
use App\Entity\Student;
use App\Entity\Subject;
use App\Form\CategoryType;
use App\Form\FinalGradeType;
use App\Form\GradeCategoryType;
use App\Form\GradeType;
use App\Form\GroupBySubjectType;
use App\Form\SubjectType;
use App\Repository\GradeCategoryRepository;
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

            $classes= $this->getDoctrine()->getRepository(Classes::class)->findClasses($groupId, $subjectId);
            #echo "<pre>";
            #var_dump($classes);
            #die;
            $classesId = $classes[0]['id'];

            return $this->redirectToRoute('studentsgrades', array('classesId' => $classesId));

        }

        return $this -> render('pages/grades/grades.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/teacherHomepage/grades/{classesId}", name="studentsgrades")
     */
    public function studentsgrades(Request $request, $classesId)
    {
        $students = $this -> studentRepository ->findStudentsByClasses($classesId);

        $categories = $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findGradeCategory($classesId, "Final");
        #echo "<pre>";
        #var_dump($categories);
        #die;

        $grades =  $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findGrades($classesId, "Final");

        $category = new GradeCategory();
        $form = $this -> createForm(CategoryType::class, $category);
        $form2 = $this -> createForm(GradeCategoryType::class, $category, ['classesId' => $classesId]);
        $form->handleRequest($request);

        $em = $this ->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()) {


            $category = $form->get('category_name')->getData();
            $classes = $em->getRepository(Classes::class)->find($classesId);

            $gradecategory = new GradeCategory();
            $gradecategory -> setCategoryName($category);
            $gradecategory -> setClasses($classes);

            $em->persist($gradecategory);
            $em->flush();

            return $this->redirectToRoute('studentsgrades', array('classesId' => $classesId));
        }
        //form for category delation
        $gradecategory = new GradeCategory();
        $form2 = $this -> createForm(GradeCategoryType::class, $gradecategory, ['classesId' => $classesId]);
        $form2->handleRequest($request);
        if($form2->isSubmitted() && $form2->isValid()) {

            $category = $form2->get('category')->getData();
            #echo "<pre>";
            #var_dump($category);
            #die;
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager ->flush();

            return $this->redirectToRoute('studentsgrades', array('classesId' => $classesId));
        }
        $subject = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getSubjectName();
        $group = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getGroup() -> getGroupName();

        return $this -> render('pages/grades/studentsgrades.html.twig', ['students'=> $students, 'categories'=> $categories, 'grades' => $grades,
            'subject' => $subject, 'group' => $group,
            'classesId' => $classesId, 'form'=>$form->createView(), 'form2'=>$form2->createView()]);
    }


    /**
     * @Route("/teacherHomepage/grades/{classesId}/{id}/edit", name="studentsgrades_edit")
     */
    public function editstudentsgrades(Request $request, $classesId, $id)
    {
        $subject = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getSubjectName();
        #echo "<pre>";
        #var_dump($classes);
        #die;

        $grade = new Grade();
        $form = $this -> createForm(GradeType::class, $grade, ['classesId' => $classesId]);
        $form->handleRequest($request);

        $em = $this ->getDoctrine()->getManager();
        $user = $em ->getRepository(Student::class) ->find((int)$id);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $category = $form->get('category')->getData();
            $grade = $form->get('grade')->getData();

            //Ids do spradzenia czy ocena już istnieje
            $categoryId = $category->getId();
            $gradeId = $this->getDoctrine()->getRepository(Grade::class)->findGrade($categoryId, (int)$id, $classesId);

            //sprawdzam czy ocena isnieje
            if ($gradeId) {
                $grade_edit = $this->getDoctrine()->getRepository(Grade::Class)->find($gradeId[0]['id']);
                $grade_edit->setGrade($grade);
                $em->persist($grade_edit);
                $em->flush();

            } else {
                $classes = $em->getRepository(Classes::class)->find($classesId);
                $notice = new Grade();
                $notice->setCategory($category);
                $notice->setGrade($grade);
                $notice->setClasses($classes);
                $notice->setStudent($user);
                $notice->setDate(new \DateTime());

                $em->persist($notice);
                $em->flush();

            }

            return $this->redirectToRoute('studentsgrades', array('classesId' => $classesId));

        }
        return $this->render('pages/grades/addgrade.html.twig', ['form'=>$form->createView() , 'user' => $user, 'subject' => $subject, 'classesId' => $classesId]);
    }


    /**
     * @Route("/teacherHomepage/grades/{classesId}/{id}/delete", name="studentsgrades_delete")
     */
    public function deletegrade(Request $request, $classesId, $id)
    {
        $subject = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getSubjectName();

        $category = new GradeCategory();
        $form = $this -> createForm(GradeCategoryType::class, $category, ['classesId' => $classesId]);
        $form->handleRequest($request);

        $em = $this ->getDoctrine()->getManager();
        $user = $em ->getRepository(Student::class) ->find((int)$id);

        if($form->isSubmitted() && $form->isValid()) {

            $categoryId = $form->get('category')->getData() -> getId();

            $gradeId = $this -> getDoctrine() -> getRepository(Grade::class) -> findGrade($categoryId, (int)$id, $classesId);
            $grade = $this -> getDoctrine() -> getRepository(Grade::class) -> find($gradeId[0]['id']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grade);
            $entityManager ->flush();

            return $this->redirectToRoute('studentsgrades', array('classesId' => $classesId));
        }

        return $this->render('pages/grades/deletegrade.html.twig', ['form'=>$form->createView() ,  'user' => $user, 'subject' => $subject, 'classesId' => $classesId]);

    }

    //------------------------------------FINAL GRADES ----------------------------------------


    /**
     * @Route("/teacherHomepage/finalgrades", name="finalgrades")
     */
    public function finalgrades(Request $request)
    {
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();

        $classes = new Classes();
        $form = $this -> createForm(SubjectType::class, $classes, ['userId'=>$userId]);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $groupId = $form -> get('group') -> getData() -> getId();
            $subjectId = $form -> get('subject') -> getData() -> getId();

            $classes= $this->getDoctrine()->getRepository(Classes::class)->findClasses($groupId, $subjectId);
            $classesId = $classes[0]['id'];

            return $this->redirectToRoute('students_final_grades', array('classesId' => $classesId));

        }

        return $this -> render('pages/grades/finalgrades.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/teacherHomepage/finalgrades/{classesId}", name="students_final_grades")
     */
    public function studentsfinalgrades(Request $request, $classesId)
    {
        $students = $this -> studentRepository ->findStudentsByClasses($classesId);
        $subject = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getSubjectName();
        $group = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getGroup() -> getGroupName();

        #echo "<pre>";
        #var_dump($group);
        #die;

        $grades =  $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findFinalGrades($classesId, "Final");



        return $this -> render('pages/grades/studentsfinalgrades.html.twig', ['students'=> $students, 'grades' => $grades,
            'classesId' => $classesId, 'subject' => $subject, 'group' => $group]);
    }

    /**
     * @Route("/teacherHomepage/finalgrades/{classesId}/{id}/edit", name="studentsfinalgrades_edit")
     */
    public function editstudentsfinalgrades(Request $request, $classesId, $id)
    {
        $subject = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getSubjectName();

        $grade = new Grade();
        $form = $this -> createForm(FinalGradeType::class, $grade);
        $form->handleRequest($request);

        $em = $this ->getDoctrine()->getManager();
        $user = $em ->getRepository(Student::class) ->find((int)$id);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $grade = $form->get('grade')->getData();

            //Ids do sprawdzenia czy ocena już istnieje
            $findcategory = $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findFinalCategory($classesId, "Final");
            $categoryId = $findcategory[0]['id'];
            $category = $this ->  getDoctrine() -> getRepository(GradeCategory::class) -> find($categoryId);

            $gradeId = $this->getDoctrine()->getRepository(Grade::class)->findGrade($categoryId, (int)$id, $classesId);

            //sprawdzam czy ocena isnieje
            if ($gradeId) {
                $grade_edit = $this->getDoctrine()->getRepository(Grade::Class)->find($gradeId[0]['id']);
                $grade_edit->setGrade($grade);
                $em->persist($grade_edit);
                $em->flush();

            } else {
                $classes = $em->getRepository(Classes::class)->find($classesId);
                $notice = new Grade();
                $notice->setCategory($category);
                $notice->setGrade($grade);
                $notice->setClasses($classes);
                $notice->setStudent($user);
                $notice->setDate(new \DateTime());

                $em->persist($notice);
                $em->flush();

            }

            return $this->redirectToRoute('students_final_grades', array('classesId' => $classesId));

        }
        return $this->render('pages/grades/addfinalgrade.html.twig', ['form'=>$form->createView() , 'user' => $user, 'subject' => $subject, 'classesId' => $classesId]);
    }

    /**
     * @Route("/teacherHomepage/finalgrades/{classesId}/{id}/delete", name="studentsfinalgrades_delete")
     * Method({"DELETE"})
     */
    public function deletefinalgrade(Request $request, $classesId, $id)
    {
        $students = $this -> studentRepository ->findStudentsByClasses($classesId);
        $subject = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getSubjectName();
        $group = $this -> getDoctrine() -> getRepository(Classes::class) -> find($classesId) -> getSubject() -> getGroup() -> getGroupName();
        $findcategory = $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findFinalCategory($classesId, "Final");
        $categoryId = $findcategory[0]['id'];

        $findgrade= $this -> getDoctrine() -> getRepository(Grade::class) -> findGrade($categoryId, (int)$id, $classesId);
        #echo "<pre>";
        #var_dump($gradeId);
        #die;

        if ($findgrade){

            $grade = $this -> getDoctrine() -> getRepository(Grade::class) -> find($findgrade[0]['id']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grade);
            $entityManager ->flush();
            $this->addFlash('info', 'Grade is removed successfully');
        }else{
            $this->addFlash('error', 'Grade is not available');
        }

        $grades =  $this -> getDoctrine() -> getRepository(GradeCategory::class) -> findFinalGrades($classesId, "Final");

        return $this -> redirect($this -> generateUrl('students_final_grades', ['students'=> $students, 'grades' => $grades,
            'classesId' => $classesId, 'subject' => $subject, 'group' => $group]));

    }


}

