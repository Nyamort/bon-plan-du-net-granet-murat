<?php

namespace App\Entity;

use App\Repository\TypeDeReductionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeDeReductionRepository::class)]
class TypeDeReduction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'typeDeReduction', targetEntity: CodePromo::class, orphanRemoval: true)]
    private Collection $codePromos;

    public function __construct()
    {
        $this->codePromos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, CodePromo>
     */
    public function getCodePromos(): Collection
    {
        return $this->codePromos;
    }

    public function addCodePromo(CodePromo $codePromo): self
    {
        if (!$this->codePromos->contains($codePromo)) {
            $this->codePromos->add($codePromo);
            $codePromo->setTypeDeReduction($this);
        }

        return $this;
    }

    public function removeCodePromo(CodePromo $codePromo): self
    {
        if ($this->codePromos->removeElement($codePromo)) {
            // set the owning side to null (unless already changed)
            if ($codePromo->getTypeDeReduction() === $this) {
                $codePromo->setTypeDeReduction(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }


}
