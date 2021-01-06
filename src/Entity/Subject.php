<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubjectRepository::class)
 */
class Subject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $subject_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubjectName()
    {
        return $this->subject_name;
    }

    public function setSubjectName($subject_name): void
    {
        $this->subject_name = $subject_name;
    }


}
