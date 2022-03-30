<?php

namespace App\Dto\User;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class UserRegisterInput
{
    #[Assert\NotBlank]
    #[Assert\Email]
	#[Groups("user:write")]
    private string $email;

    #[Assert\NotBlank]
	#[Groups("user:write")]
    private string $password;

	#[Assert\NotBlank]
	#[Groups("user:write")]
    private $firstName;

	#[Assert\NotBlank]
	#[Groups("user:write")]
    private $lastName;


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

	public function getFirstName(): string 
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): self 
	{
		$this->firstName = $firstName;

        return $this;
	}

	public function getLastName(): string 
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): self 
	{
		$this->lastName = $lastName;

        return $this;
	}
}