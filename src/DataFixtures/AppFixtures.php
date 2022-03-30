<?php

namespace App\DataFixtures;

use App\Entity\Bed;
use App\Entity\Housing;
use App\Entity\HousingType;
use App\Entity\Room;
use App\Entity\RoomBed;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
	public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
		$admin = new User();
		$admin
			->setFirstName("user")
			->setLastName("admin")
			->setEmail("a@a.a")
			->setPassword($this->hasher->hashPassword($admin, "aaaaaa"))
			->setRoles(["ROLE_ADMIN"])
		;
		$manager->persist($admin);
		$admin->setIsEmailVerified(true);

		$verifiedUser = new User();
		$verifiedUser
			->setFirstName("user")
			->setLastName("verified")
			->setEmail("v@v.v")
			->setPassword($this->hasher->hashPassword($verifiedUser, "vvvvvv"))
		;
		$manager->persist($verifiedUser);
		$verifiedUser->setIsEmailVerified(true);

		$unverifiedUser = new User();
		$unverifiedUser
			->setFirstName("user")
			->setLastName("unverified")
			->setEmail("u@u.u")
			->setPassword(
				$this->hasher->hashPassword($unverifiedUser, "uuuuuu")
			)
		;
		$manager->persist($unverifiedUser);

		$simpleBed = new Bed();
		$simpleBed
			->setPlaces(1)
			->setType("Simple Bed")
		;
		$manager->persist($simpleBed);

		$room = new Room();
		$room->setSize(32);
		$manager->persist($room);

		$roomBed = new RoomBed();
		$roomBed
			->addRoom($room)
			->addType($simpleBed)
			->setQuantity(2)
		;
		$manager->persist($roomBed);

		$appartementType = new HousingType();
		$appartementType->setName("appartement");
		$manager->persist($appartementType);

		$housing = new Housing();
		$housing
			->addRoom($room)
			->setCity("Paris")
			->setCountry("France")
			->setSize(43)
			->setStreet("1 rue du Général de Gaulle")
			->setZip("75001")
			->setType($appartementType)
			->setUser($admin)
		;
		$manager->persist($housing);

        $manager->flush();
    }
}
