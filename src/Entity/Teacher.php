<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
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
     * @ORM\Column(type="text", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Address")
     */
    private $address;
    /**
 * @return mixed
 */
public function getFirstname()
{
    return $this->firstname;
}/**
 * @param mixed $firstname
 */
public function setFirstname($firstname): void
{
    $this->firstname = $firstname;
}/**
 * @return mixed
 */
public function getLastname()
{
    return $this->lastname;
}/**
 * @param mixed $lastname
 */
public function setLastname($lastname): void
{
    $this->lastname = $lastname;
}/**
 * @return mixed
 */
public function getEmail()
{
    return $this->email;
}/**
 * @param mixed $email
 */
public function setEmail($email): void
{
    $this->email = $email;
}/**
 * @return mixed
 */
public function getTitle()
{
    return $this->title;
}/**
 * @param mixed $title
 */
public function setTitle($title): void
{
    $this->title = $title;
}/**
 * @return mixed
 */
public function getAddress()
{
    return $this->address;
}/**
 * @param mixed $address
 */
public function setAddress($address): void
{
    $this->address = $address;
}

    public function getId(): ?int
    {
        return $this->id;
    }

}
