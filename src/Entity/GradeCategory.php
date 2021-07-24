<?php

namespace App\Entity;

use App\Repository\GradeCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GradeCategoryRepository::class)
 */
class GradeCategory
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
    private $category_name;

    /**
     * @ORM\ManyToOne(targetEntity="Classes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classes;



    public function getClasses()
    {
        return $this->classes;
    }

    public function setClasses($classes): void
    {
        $this->classes = $classes;
    }


    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * @param mixed $category_name
     */
    public function setCategoryName($category_name): void
    {
        $this->category_name = $category_name;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(){
        return (string) $this->category_name;
    }




}
