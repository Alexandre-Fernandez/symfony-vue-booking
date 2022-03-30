<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalRepository::class)]
class Rental
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $startedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $endedAt;

    #[ORM\Column(type: 'float')]
    private $pricePerNight;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rentals')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Housing::class, inversedBy: 'rentals')]
    #[ORM\JoinColumn(nullable: false)]
    private $housing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeImmutable $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getPricePerNight(): ?float
    {
        return $this->pricePerNight;
    }

    public function setPricePerNight(float $pricePerNight): self
    {
        $this->pricePerNight = $pricePerNight;

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
}
