<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="text", length=100)
     */
    private $street_address;
    /**
     * @ORM\Column(type="text", length=255)
     */
    private $locality;
    /**
     * @ORM\Column(type="text", length=255)
     */
    private $postal_code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreetAddress()
    {
        return $this->street_address;
    }

    public function setStreetAddress($street_address): self
    {
        $this->street_address = $street_address;
        return $this;
    }

    public function getLocality()
    {
        return $this->locality;
    }

    public function setLocality($locality)
    {
        $this->locality = $locality;
        return $this;
    }

    public function getPostalCode()
    {
        return $this->postal_code;
    }

    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
        return $this;
    }


}
