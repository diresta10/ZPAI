<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController{
    /**
     * @Route("/", name="homepage")
     * Method({"GET"})
     */
    public function index(){

        $articles = ['Article 1', 'Article 2'];
        $articles = $this->getDoctrine()->getRepository(Article::class)-> findAll();
        return $this -> render('pages/index.html.twig');

    }
    /**
     * @Route("/studentLogin", name="studentLogin")
     */
    public function studentLogin(){
        return $this->render('pages/studentLogin.html.twig');
    }
    /**
     * @Route("/teacherLogin", name="teacherLogin")
     */
    public function teacherLogin(){
        return $this->render('pages/teacherLogin.html.twig');
    }



    ///**
     //* @Route("/article/save")
    // */
    /*public function save(){
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setTitle('Article Two');
        $article->setBody('This is the body for article two');

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('Saves an article with the id of'.$article->getId());

    }*/

}

