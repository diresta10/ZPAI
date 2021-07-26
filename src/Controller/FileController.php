<?php
namespace App\Controller;

use App\Entity\Classes;
use App\Entity\File;
use App\Entity\Grade;
use App\Form\FilesType;
use App\Services\FileUploader;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FileController extends AbstractController{

    /**
     * @Route("/teacherHomepage/files/add", name="add_file")
     * Method({"GET", "POST"})
     */
    public function uploadfile(Request $request, FileUploader $fileUploader){

        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $classes = new Classes();
        $form = $this -> createForm(FilesType::class, $classes, ['userId' => $userId]);

        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */

            $file = $request -> files -> get('files')['file'];

            if($file){

                $groupId = $form -> get('group') -> getData() -> getId();
                $subjectId = $form -> get('subject') -> getData() -> getId();

                $getclasses= $this->getDoctrine()->getRepository(Grade::class)->findClasses($groupId, $subjectId);
                $classes = $user = $entityManager ->getRepository(Classes::class) ->find($getclasses[0]['id']);

                $uploads_directory = $this -> getParameter('uploads_directory');
                $filename = $fileUploader ->uploadFile($file);

                $fileClass = new File();
                $fileClass -> setFilename ($filename);
                $fileClass -> setClasses($classes);
                $fileClass -> setCreated(new \DateTime());
                $entityManager -> persist($fileClass);
                $entityManager ->flush();
                $this->addFlash('info', 'File is upload successfully !');
            }

            //echo "<pre>";
            //var_dump($file); die;
            return $this->redirectToRoute('add_file');
        }

        return $this->render('pages/files/files.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/teacherHomepage/files", name="my_files")
     * Method({"GET"})
     */
    public function myfiles(Request $request){




        return $this->render('pages/files/downloadfile.html.twig', []);

    }



    /**
     * @Route("/teacherHomepage/files/download/{file}", name="file_download")
     * Method({"GET"})
     */
    public function downloadfile(Request $request, $file){

        //echo "<pre>";
        //var_dump($file); die;
        $displayName = 'image-data-' . $this->getUser()->getId() .'.jpg';
        $file_with_path = $this->getParameter ( 'uploads_directory2' ) . "/" . $file;
        $response = new BinaryFileResponse ( $file_with_path );
        $response->headers->set ( 'Content-Type', 'text/plain' );
        $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $displayName );
        return $response;

    }



}

