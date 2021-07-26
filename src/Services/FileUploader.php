<?php


namespace App\Services;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader
{
    /**
     * FileUploader constructor.
     * @var ContainerInterface
     */
    public function __construct(ContainerInterface $container){

        $this ->container = $container;
    }

    public function uploadFile(UploadedFile $file){

        $uploads_directory = $this ->container->getParameter('uploads_directory');
        $filename = md5(uniqid())  . '.' . $file-> guessExtension();

        $file -> move(
            $uploads_directory,
            $filename
        );

        return $filename;


    }

}