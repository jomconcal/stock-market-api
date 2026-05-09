<?php

declare(strict_types=1);

namespace App\Application\AppUser\Service;

use App\Application\AppUser\DTO\RegisterUserInputDto;
use App\Application\AppUser\DTO\RegisterUserOutputDto;
use App\Application\AppUser\Mapper\AppUserFactory;
use App\Domain\AppUser\Repository\AppUserRepositoryInterface;

class RegisterUserService
{
    public function __construct(
        private AppUserRepositoryInterface $appUserRepository,
    ) {
    }

    public function execute(RegisterUserInputDto $registerUserInputDto): RegisterUserOutputDto
    {
        $appUser = AppUserFactory::fromInputDto($registerUserInputDto);

        $existingUser = $this->appUserRepository->findByEmail($appUser->getEmail());
        if ($existingUser instanceof \App\Domain\AppUser\Entity\AppUser) {
            return RegisterUserOutputDto::createFromDuplicated($appUser->getEmail());
        }

        $this->appUserRepository->save($appUser);

        return RegisterUserOutputDto::createFromRegister($appUser->getEmail());
    }
}
