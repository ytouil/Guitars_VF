<?php
// src/Entity/Inventory.php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[Entity(repositoryClass: 'App\Repository\Implementations\InventoryRepository')]
#[Table(name: 'inventory')]
class Inventory
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(type: 'string', length: 255)]
    private string $name;

    // Adding the image attribute
    #[Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    #[OneToOne(targetEntity: Member::class, inversedBy: 'inventory')]
    #[JoinColumn(name: 'member_id', referencedColumnName: 'id')]
    private $member;

    #[OneToMany(targetEntity: Guitar::class, mappedBy: 'inventory')]
    private $guitars;

    public function __construct()
    {
        $this->guitars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function setMember(Member $member): self
    {
        $this->member = $member;
        return $this;
    }

    public function getGuitars(): Collection
    {
        return $this->guitars;
    }

    public function addGuitar(Guitar $guitar): self
    {
        if (!$this->guitars->contains($guitar)) {
            $this->guitars[] = $guitar;
            $guitar->setInventory($this);
        }

        return $this;
    }

    public function removeGuitar(Guitar $guitar): self
    {
        if ($this->guitars->contains($guitar)) {
            $this->guitars->removeElement($guitar);
            if ($guitar->getInventory() === $this) {
                $guitar->setInventory(null);
            }
        }

        return $this;
    }

    // Getter and Setter for the image attribute
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
}
