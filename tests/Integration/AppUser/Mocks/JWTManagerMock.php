<?php

declare(strict_types=1);

namespace App\Tests\Integration\AppUser\Mocks;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTManagerMock implements JWTTokenManagerInterface
{
    public function create(UserInterface $user): string
    {
        return 'fake-jwt-token-for-tests';
    }

    public function createFromPayload(UserInterface $user, array $payload = []): string
    {
        return 'fake-jwt-token-from-payload';
    }

    public function decode(TokenInterface $token): array|bool
    {
        return ['username' => 'test'];
    }

    public function parse(string $token): array
    {
        return ['username' => 'test'];
    }

    public function getUserIdClaim(): string
    {
        return 'username';
    }
}
