<?php

namespace App\Controller;

use App\Dto\User\UserRegisterInput;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class RegisterController extends AbstractController
{
	public function __construct(
		private UserPasswordHasherInterface $hasher, 
		private MailerService $mailer
	) {}

    public function __invoke(UserRegisterInput $data, UserRepository $userRepository): Response
    {
		$user = $userRepository->findOneBy(["email" => $data->getEmail()]);
		if($user) throw new \Exception("Email already exists");

		$user = new User();
		$user
			->setEmail($data->getEmail())
			->setPassword($this->hasher->hashPassword($user, $data->getPassword()))
			->setFirstName($data->getFirstName())
			->setLastName($data->getLastName())
		;
		$userRepository->save($user);

		$emailVerificationUrl = $this->mailer->generateUserEmailVerificationUrl($user);
		$this->mailer->sendEmailVerification($user->getEmail(), $emailVerificationUrl);

        return $this->json(["message" => "Unverified account created successfully"], 201);
    }

	#[Route("/api/auth/register/verify", name:"api_auth_register_verify", methods: ["GET"])]
	public function verifyEmail(
		Request $request, 
		UserRepository $userRepository, 
		AuthenticationSuccessHandler $authSuccessHandler
	): Response {
		$id = $request->get('id');
		if (!$id) throw new \Exception("User not found");
		$user = $userRepository->find($id);
		if (!$user) throw new \Exception("User not registered");

		// $this->mailer can throw VerifyEmailExceptionInterface
        $this->mailer->verifyUserEmailVerificationUrl($user, $request->getUri());

		$user->setIsEmailVerified(true);
		$userRepository->save($user);
		
        return $authSuccessHandler->handleAuthenticationSuccess($user);
    }
}
