<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class MailerService {
	public function __construct(
		private MailerInterface $mailer, 
		private VerifyEmailHelperInterface $verifyEmailHelper
	) {}

	public function generateUserEmailVerificationUrl(User $user): string {
		$signatureComponents = $this->verifyEmailHelper->generateSignature(
			"api_auth_register_verify",
			$user->getId(),
			$user->getEmail(),
			['id' => $user->getId()]
		);
		return $signatureComponents->getSignedUrl();
	}

	function sendEmailVerification(string $to, string $emailVerificationUrl) {
		$email = new TemplatedEmail();
        $email->from('send@example.com');
        $email->to($to);
        $email->htmlTemplate('register/confirmation_email.html.twig');
        $email->context(['signedUrl' => $emailVerificationUrl]);
		$this->mailer->send($email);
	}

	function verifyUserEmailVerificationUrl(User $user, string $url) {
		$this->verifyEmailHelper->validateEmailConfirmation($url, $user->getId(), $user->getEmail());
	}
} 