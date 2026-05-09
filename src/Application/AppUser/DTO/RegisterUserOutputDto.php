<?php

namespace App\Application\AppUser\DTO;

class RegisterUserOutputDto
{
    private function __construct(
        public string $email,
        public bool $registered,
    ) {
    }

    public static function createFromRegister(string $email): self
    {
        return new self($email, true);
    }

    public static function createFromDuplicated(string $email): self
    {
        return new self($email, false);
    }
}
