<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClassesRepository::class)
 */
class Classes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher")
     */
    private $teacher;


    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="classes")
     * @Assert\NotBlank()
     **/
    private $subject;




    /**
     * @ORM\Column(type="text", length=20)
     */
    private $day;

    /**
     * @ORM\Column(type="time")
     */
    private $time;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getSubject(): ?Subject
    {
        return $this->subject;
    }
    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void
    {
        $this->teacher = $teacher;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day): void
    {
        $this->day = $day;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }







}
