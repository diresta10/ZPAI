<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`sgroup`")
 */
class Sgroup
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
    private $group_name;


    /**
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="group")
     **/
    private $subjects;
    public function __construct()
    {
        $this -> subjects = new ArrayCollection();
    }


    public function getGroupName()
    {
        return (string) $this->group_name;
    }

    public function setGroupName($group_name): self
    {
        $this->group_name = $group_name;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|Subject[]
     */
    public function getSubjects(): Collection
    {
        return $this -> subjects;
    }
    public function addSubject(Subject $subject): self
    {
        if(!$this->subjects->contains($subject)){
            $this -> subjects[] = $subject;
            $subject -> setGroup($this);
        }
        return $this;
    }

    public function removeSubject(Subject $subject):self
    {
        if( $this->subjects->contains($subject)){
            $this -> subjects -> removeElement($subject);

            if ($subject->getGroup() === $this){
                $subject -> setGroup(null);
            }
        }
        return $this;
    }

    public function __toString(){
        return (string) $this->group_name;
    }


}
