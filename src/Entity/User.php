<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\RegisterController;
use App\Dto\User\UserRegisterInput;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
	collectionOperations: [
		"post",
		"auth_register" => [
			"input" => UserRegisterInput::class,
			"controller" => RegisterController::class,
			"method" => "POST",
			"path" => "/auth/register",
			"openapi_context" => [
				"tags" => ["Auth"],
				"responses" => [
					"201" => [
						"description" => "Succesfull response message"
					]
				]
			]
		],
		'get' => [
			'security' => 'is_granted("ROLE_ADMIN")',
		],
	],
	itemOperations: [
		'get' => [
			'security' => 'is_granted("ROLE_ADMIN")',
		],
	],
	denormalizationContext: ["groups" => ["user:write"]],
	normalizationContext: ["groups" => ["user:read"]],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
	#[Groups("user:read", "user:write")]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
	#[Groups("user:read", "user:write")]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
	#[Groups("user:read", "user:write")]
    private $lastName;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Housing::class)]
    private $housings;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Rental::class)]
    private $rentals;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class)]
    private $reviews;

    #[ORM\Column(type: 'boolean')]
    private $isEmailVerified;

    public function __construct()
    {
        $this->housings = new ArrayCollection();
        $this->rentals = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

	// used by lexik/jwt-authentication-bundle to retrieve the User
	public function getUsername(): ?string {
                  		return $this->email;
                  	}

    public function getId(): ?int
    {
        return $this->id;
    }

	public function setId(int $id): self {
         		$this->id = $id;
         
         		return $this;
         	}

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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
	public function setCreatedAtNow(): self
	{
		$this->createdAt = new \DateTimeImmutable();
	
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
            $housing->setUser($this);
        }

        return $this;
    }

    public function removeHousing(Housing $housing): self
    {
        if ($this->housings->removeElement($housing)) {
            // set the owning side to null (unless already changed)
            if ($housing->getUser() === $this) {
                $housing->setUser(null);
            }
        }

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
            $rental->setUser($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getUser() === $this) {
                $rental->setUser(null);
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
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

    public function getIsEmailVerified(): ?bool
    {
        return $this->isEmailVerified;
    }

    public function setIsEmailVerified(bool $isEmailVerified): self
    {
        $this->isEmailVerified = $isEmailVerified;

        return $this;
    }

	#[ORM\PrePersist]
	public function setIsEmailVerifiedFalse(): self
    {
        $this->isEmailVerified = false;

        return $this;
    }	

	public static function createFromPayload($username, array $payload)
	{
		return (new User())
			->setEmail($username ?? "")
			->setIsEmailVerified($payload["isEmailVerified"] ?? false)
			->setRoles($payload["roles"] ?? [])
		;
	}
}
