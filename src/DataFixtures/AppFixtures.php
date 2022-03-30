<?php

namespace App\DataFixtures;

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

        $manager->flush();
    }
}
