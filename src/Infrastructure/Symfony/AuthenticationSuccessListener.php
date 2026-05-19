<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony;

use App\Domain\AppUser\Entity\AppUser;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();

        $user = $event->getUser();

        if (!$user instanceof AppUser) {
            return;
        }

        $data['email'] = $user->getEmail();
        $data['name'] = $user->getName();
        $data['surname'] = $user->getSurname();
        $data['roles'] = $user->getRoles();

        $event->setData($data);
    }
}
