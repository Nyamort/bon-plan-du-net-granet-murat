<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['publication'])]
    private ?int $id = null;

    #[Groups(['publication'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[Groups(['publication'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups(['publication'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['publication'])]
    #[ORM\Column]
    private ?DateTimeImmutable $publishedAt = null;

    #[Groups(['publication'])]
    #[ORM\OneToOne(inversedBy: 'publication', cascade: ['persist', 'remove'])]
    private ?Deal $deal = null;

    #[Groups(['publication'])]
    #[ORM\OneToOne(inversedBy: 'publication', cascade: ['persist', 'remove'])]
    private ?CodePromo $codePromo = null;

    #[Groups(['publication'])]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'publication', targetEntity: Notation::class, orphanRemoval: true)]
    private Collection $notations;

    #[ORM\OneToMany(mappedBy: 'publication', targetEntity: Commentaire::class)]
    #[ORM\OrderBy(["publishedAt" => "DESC"])]
    private Collection $commentaires;

    #[ORM\ManyToOne(inversedBy: 'publications')]
    #[Groups(['publication'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    private int $notation = 0;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favoris')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'publications_alert')]
    private Collection $users_alert;

    public function __construct()
    {
        $this->notations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->users_alert = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishedAt(): ?DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getDeal(): ?Deal
    {
        return $this->deal;
    }

    public function setDeal(?Deal $deal): self
    {
        $this->deal = $deal;

        return $this;
    }

    public function getCodePromo(): ?CodePromo
    {
        return $this->codePromo;
    }

    public function setCodePromo(?CodePromo $codePromo): self
    {
        $this->codePromo = $codePromo;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Notation>
     */
    public function getNotations(): Collection
    {
        return $this->notations;
    }

    public function addNotation(Notation $notation): self
    {
        if (!$this->notations->contains($notation)) {
            $this->notations->add($notation);
            $notation->setPublication($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notations->removeElement($notation)) {
            // set the owning side to null (unless already changed)
            if ($notation->getPublication() === $this) {
                $notation->setPublication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPublication($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPublication() === $this) {
                $commentaire->setPublication(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return int
     */
    public function getNotation(): int
    {
        return $this->notation;
    }

    /**
     * @param int $notation
     */
    public function setNotation(int $notation): void
    {
        $this->notation = $notation;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersAlert(): Collection
    {
        return $this->users_alert;
    }

    public function addUsersAlert(User $usersAlert): self
    {
        if (!$this->users_alert->contains($usersAlert)) {
            $this->users_alert->add($usersAlert);
            $usersAlert->addPublicationsAlert($this);
        }

        return $this;
    }

    public function removeUsersAlert(User $usersAlert): self
    {
        if ($this->users_alert->removeElement($usersAlert)) {
            $usersAlert->removePublicationsAlert($this);
        }

        return $this;
    }


}
