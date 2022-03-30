<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedRepository::class)]
class Bed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $places;

    #[ORM\ManyToMany(targetEntity: RoomBed::class, mappedBy: 'type')]
    private $roomBeds;

    public function __construct()
    {
        $this->roomBeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    /**
     * @return Collection<int, RoomBed>
     */
    public function getRoomBeds(): Collection
    {
        return $this->roomBeds;
    }

    public function addRoomBed(RoomBed $roomBed): self
    {
        if (!$this->roomBeds->contains($roomBed)) {
            $this->roomBeds[] = $roomBed;
            $roomBed->addType($this);
        }

        return $this;
    }

    public function removeRoomBed(RoomBed $roomBed): self
    {
        if ($this->roomBeds->removeElement($roomBed)) {
            $roomBed->removeType($this);
        }

        return $this;
    }
}
