<?php

declare(strict_types=1);

namespace App\Application\AppUser\Mapper;

use App\Application\AppUser\DTO\RegisterUserInputDto;
use App\Domain\AppUser\Entity\AppUser;

class AppUserFactory
{
    public static function fromInputDto(RegisterUserInputDto $inputDto): AppUser
    {
        $passwordHashed = password_hash($inputDto->password, PASSWORD_DEFAULT);

        return new AppUser(
            $inputDto->email,
            $passwordHashed,
            $inputDto->name,
            $inputDto->surname,
            [$inputDto->rol],
        );
    }
}
