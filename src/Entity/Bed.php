<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BedRepository::class)]
class Bed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
	#[Groups("read:Housing")]
    private $name;

    #[ORM\Column(type: 'integer')]
	#[Groups("read:Housing")]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
