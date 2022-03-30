<?php

namespace App\Entity;

use App\Repository\HousingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HousingRepository::class)]
class Housing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $size;

    #[ORM\Column(type: 'string', length: 255)]
    private $street;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    private $zip;

    #[ORM\Column(type: 'string', length: 255)]
    private $country;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'housings')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'housing', targetEntity: Rental::class)]
    private $rentals;

    #[ORM\ManyToOne(targetEntity: HousingType::class, inversedBy: 'housings')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\OneToMany(mappedBy: 'housing', targetEntity: HousingImage::class)]
    private $images;

    #[ORM\OneToMany(mappedBy: 'housing', targetEntity: Review::class)]
    private $reviews;

    #[ORM\OneToMany(mappedBy: 'housing', targetEntity: Ad::class)]
    private $ads;

    #[ORM\ManyToMany(targetEntity: Room::class, inversedBy: 'housings')]
    private $rooms;

    public function __construct()
    {
        $this->rentals = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->ads = new ArrayCollection();
        $this->rooms = new ArrayCollection();
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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

    /**
     * @return Collection<int, Rental>
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental): self
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals[] = $rental;
            $rental->setHousing($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getHousing() === $this) {
                $rental->setHousing(null);
            }
        }

        return $this;
    }

    public function getType(): ?HousingType
    {
        return $this->type;
    }

    public function setType(?HousingType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, HousingImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(HousingImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setHousing($this);
        }

        return $this;
    }

    public function removeImage(HousingImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getHousing() === $this) {
                $image->setHousing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setHousing($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getHousing() === $this) {
                $review->setHousing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ad>
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setHousing($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->removeElement($ad)) {
            // set the owning side to null (unless already changed)
            if ($ad->getHousing() === $this) {
                $ad->setHousing(null);
            }
        }

        return $this;
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
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        $this->rooms->removeElement($room);

        return $this;
    }
}
