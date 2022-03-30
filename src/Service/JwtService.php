<?php

namespace App\Service;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;

class JwtService {
	public function __construct(private $jwtExpirationTime) {
		$this->jwtExpirationTime = $jwtExpirationTime;
	}
	
	public function fillJwtPayload(JWTCreatedEvent &$e) {
		$data = $e->getData();
		$user = $e->getUser();
		if($user instanceof User) $data["isEmailVerified"] = $user->getIsEmailVerified();
		$e->setData($data);
	}

	public function addJwtExpirationTime(AuthenticationSuccessEvent &$e) {
		$expiration = (time() + $this->jwtExpirationTime) * 1000; // to ms
		// formats to the "Token" schema (App\OpenApi\JwtDecorator->schemas['Token'])
		$e->setData([ 
			"jwt" => $e->getData()["token"],
			"expiration" => $expiration,
		]);
	}
}