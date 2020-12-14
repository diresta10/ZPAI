<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
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
    private $firstname;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="text", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Address")
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="Group")
     */
    private $group;


    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup($group): void
    {
        $this->group = $group;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }


}
