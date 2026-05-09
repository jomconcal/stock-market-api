<?php

namespace App\Application\AppUser\DTO;

class RegisterUserOutputDto
{
    private function __construct(
        public string $email,
        public bool $registered,
        public string $message,
    ) {
    }

    public static function createFromRegister(string $email): self
    {
        return new self($email, true, 'User registered successfully.');
    }

    public static function createFromDuplicated(string $email): self
    {
        return new self($email, false, 'User already exists.');
    }
}
