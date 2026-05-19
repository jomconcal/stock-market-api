<?php

namespace App\Application\AppUser\DTO;

use App\Domain\AppUser\Entity\AppUser;

class RegisterUserOutputDto
{
    private function __construct(
        public string $email,
        public string $name,
        public string $surname,
        public bool $registered,
        public string $message,
        public ?string $token = null,
    ) {
    }

    public static function createFromRegister(AppUser $appUser, string $token): self
    {
        return new self(
            $appUser->getEmail(),
            $appUser->getName(),
            $appUser->getSurname(),
            true,
            'User registered successfully.',
            $token
        );
    }

    public static function createFromDuplicated(AppUser $appUser): self
    {
        return new self(
            $appUser->getEmail(),
            $appUser->getName(),
            $appUser->getSurname(),
            false,
            'User already exists.'
        );
    }
}
