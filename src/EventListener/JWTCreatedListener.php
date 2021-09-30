<?php

namespace App\EventListener;

use App\Service\UsersService;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener {
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var UsersService
     */
    private $usersService;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, UsersService $usersService)
    {
        $this->requestStack = $requestStack;
        $this->usersService = $usersService;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $this->usersService->setLastLogin($event->getUser());
        $payload = $event->getData();
        $payload['ref'] = $event->getUser()->getRef();
        $payload['firstName'] = $event->getUser()->getFirstName();
        $payload['lastName'] = $event->getUser()->getLastName();

        $event->setData($payload);
    }
}