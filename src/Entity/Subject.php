<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FontLib\TrueType\Collection;

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


    /**
     * @ORM\ManyToOne(targetEntity="Sgroup", inversedBy="subjects")
     **/
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="Classes", mappedBy="subject")
     **/
    private $classes;
    public function __construct()
    {
        $this -> classes = new ArrayCollection();
    }

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
     * @return Collection|Classes[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClasses(Classes $class) : self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setSubject($this);
        }

        return $this;
    }

    public function removeClasses(Classes $class) : self
    {
        if ($this->classes->contains($class)) {
            $this->classes->removeElement($class);
            // set the owning side to null (unless already changed)
            if ($class->getSubject() === $this) {
                $class->setSubject(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->subject_name;
    }




}
