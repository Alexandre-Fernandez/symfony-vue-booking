<?php

namespace App\Security\Checker;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void {}

    public function checkPostAuth(UserInterface $user): void {
		if(!$user instanceof User) throw new \Exception("User not found");
		if(!$user->getIsEmailVerified()) throw new \Exception(
			"Email " . $user->getEmail() . " is not verified."
		);
    }
}