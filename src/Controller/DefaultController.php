<?php
namespace App\Controller;

use App\Entity\Notice;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController{
    /**
     * @Route("/homepage", name="homepage")
     * Method({"GET"})
     */
    public function index(){

        $articles = ['Notice 1', 'Notice 2'];
        $articles = $this->getDoctrine()->getRepository(Notice::class)-> findAll();
        return $this -> render('pages/index.html.twig');

    }

    /**
     * @Route("/", name="welcome")
     */
    public function welcome(){
        return $this->render('pages/welcome.html.twig');
    }



    ///**
     //* @Route("/article/save")
    // */
    /*public function save(){
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Notice();
        $article->setTitle('Notice Two');
        $article->setBody('This is the body for article two');

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('Saves an article with the id of'.$article->getId());

    }*/

}

