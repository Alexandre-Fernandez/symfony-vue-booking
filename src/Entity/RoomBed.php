<?php

namespace App\Entity;

use App\Repository\RoomBedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomBedRepository::class)]
class RoomBed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Room::class, mappedBy: 'beds')]
    private $rooms;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\ManyToMany(targetEntity: Bed::class, inversedBy: 'roomBeds')]
    private $type;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->addBed($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->removeElement($room)) {
            $room->removeBed($this);
        }

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, Bed>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Bed $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }

    public function removeType(Bed $type): self
    {
        $this->type->removeElement($type);

        return $this;
    }
}
