<?php

namespace App\Entity;

use App\Repository\DealRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DealRepository::class)]
class Deal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $regularPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $fees = null;

    #[ORM\OneToOne(mappedBy: 'deal', cascade: ['persist', 'remove'])]
    private ?Publication $publication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRegularPrice(): ?string
    {
        return $this->regularPrice;
    }

    public function setRegularPrice(string $regularPrice): self
    {
        $this->regularPrice = $regularPrice;

        return $this;
    }

    public function getFees(): ?string
    {
        return $this->fees;
    }

    public function setFees(?string $fees): self
    {
        $this->fees = $fees;

        return $this;
    }

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        // unset the owning side of the relation if necessary
        if ($publication === null && $this->publication !== null) {
            $this->publication->setDeal(null);
        }

        // set the owning side of the relation if necessary
        if ($publication !== null && $publication->getDeal() !== $this) {
            $publication->setDeal($this);
        }

        $this->publication = $publication;

        return $this;
    }
}
