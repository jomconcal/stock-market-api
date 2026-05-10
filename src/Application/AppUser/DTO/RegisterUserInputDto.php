<?php

declare(strict_types=1);

namespace App\Application\AppUser\DTO;

use App\Domain\AppUser\UserRol;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserInputDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 8)]
        #[Assert\Regex(
            pattern: '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            message: 'Password must contain uppercase, number and symbol'
        )]
        public string $password,

        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $surname,

        public string $rol = UserRol::ROLE_USER->value,
    ) {
    }
}
