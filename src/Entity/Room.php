<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
	#[Groups("read:Housing")]
    private $id;

    #[ORM\Column(type: 'integer')]
	#[Groups("read:Housing")]
    private $size;

    #[ORM\ManyToMany(targetEntity: Housing::class, mappedBy: 'rooms')]
    private $housings;

    #[ORM\ManyToMany(targetEntity: RoomBed::class, inversedBy: 'rooms')]
	#[Groups("read:Housing")]
    private $beds;

    public function __construct()
    {
        $this->housings = new ArrayCollection();
        $this->beds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, Housing>
     */
    public function getHousings(): Collection
    {
        return $this->housings;
    }

    public function addHousing(Housing $housing): self
    {
        if (!$this->housings->contains($housing)) {
            $this->housings[] = $housing;
            $housing->addRoom($this);
        }

        return $this;
    }

    public function removeHousing(Housing $housing): self
    {
        if ($this->housings->removeElement($housing)) {
            $housing->removeRoom($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RoomBed>
     */
    public function getBeds(): Collection
    {
        return $this->beds;
    }

    public function addBed(RoomBed $bed): self
    {
        if (!$this->beds->contains($bed)) {
            $this->beds[] = $bed;
        }

        return $this;
    }

    public function removeBed(RoomBed $bed): self
    {
        $this->beds->removeElement($bed);

        return $this;
    }
}
