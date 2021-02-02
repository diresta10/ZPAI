<?php
namespace App\Controller;

use App\Entity\Notice;
use App\Repository\NoticeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController{
    /**
     * @Route("/homepage", name="homepage")

     */
    public function index(){

        $articles = $this->getDoctrine()->getRepository(Notice::class)-> findAll();
        return $this -> render('pages/index.html.twig', array ('articles' => $articles));

    }
    /**
     * @Route("/teacherHomepage", name="teacherHomepage")
     * @param NoticeRepository $noticeRepository
     * Method({"GET"})
     */
    public function teacherHomepage(NoticeRepository $noticeRepository){
        $articles = $noticeRepository ->findPublishedNotice();

        return $this -> render('pages/teacherHomepage.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/", name="welcome")
     */
    public function welcome(){
        return $this->render('pages/welcome.html.twig');
    }
    /**/



}

