<?php

namespace App\Entity;

use App\Repository\CodePromoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodePromoRepository::class)]
class CodePromo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expiredAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'codePromos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDeReduction $typeDeReduction = null;

    #[ORM\OneToOne(mappedBy: 'codePromo', cascade: ['persist', 'remove'])]
    private ?Publication $publication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(?\DateTimeImmutable $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTypeDeReduction(): ?TypeDeReduction
    {
        return $this->typeDeReduction;
    }

    public function setTypeDeReduction(?TypeDeReduction $typeDeReduction): self
    {
        $this->typeDeReduction = $typeDeReduction;

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
            $this->publication->setCodePromo(null);
        }

        // set the owning side of the relation if necessary
        if ($publication !== null && $publication->getCodePromo() !== $this) {
            $publication->setCodePromo($this);
        }

        $this->publication = $publication;

        return $this;
    }
}
