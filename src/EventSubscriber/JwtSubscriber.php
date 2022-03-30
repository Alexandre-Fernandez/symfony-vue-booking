<?php

namespace App\EventSubscriber;

use App\Service\JwtService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtSubscriber implements EventSubscriberInterface
{
	public function __construct(private JwtService $jwtService) {}

    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onJwtCreated',
			'lexik_jwt_authentication.on_authentication_success' => 'onAuthenticationSuccess',
        ];
    }

	public function onJwtCreated(JWTCreatedEvent $e) {
        $this->jwtService->fillJwtPayload($e);
    }

	public function onAuthenticationSuccess(AuthenticationSuccessEvent $e) {
        $this->jwtService->addJwtExpirationTime($e);
    }
}
