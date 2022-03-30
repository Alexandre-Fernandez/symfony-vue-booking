<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $comment;

    #[ORM\Column(type: 'integer')]
    private $score;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Housing::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private $housing;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getHousing(): ?Housing
    {
        return $this->housing;
    }

    public function setHousing(?Housing $housing): self
    {
        $this->housing = $housing;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

	#[ORM\PrePersist]
	public function setCreatedAtValue(): self
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }
}
