<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255)
     * @ORM\OneToMany(targetEntity=Test::class, mappedBy="address")
     */
    private $HomeNumber;

    
    public function __construct()
    {
        $this->HomeNumber = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Test[]
     */
    public function getHomeNumber(): Collection
    {
        return $this->HomeNumber;
    }

    public function addHomeNumber(Test $homeNumber): self
    {
        if (!$this->HomeNumber->contains($homeNumber)) {
            $this->HomeNumber[] = $homeNumber;
            $homeNumber->setAddress($this);
        }

        return $this;
    }

    public function removeHomeNumber(Test $homeNumber): self
    {
        if ($this->HomeNumber->removeElement($homeNumber)) {
            // set the owning side to null (unless already changed)
            if ($homeNumber->getAddress() === $this) {
                $homeNumber->setAddress(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->HomeNumber;
    }

    public function setHomeNumber(string $HomeNumber): self
    {
        $this->HomeNumber = $HomeNumber;

        return $this;
    }
}
