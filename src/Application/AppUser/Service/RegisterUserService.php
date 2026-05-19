<?php

declare(strict_types=1);

namespace App\Application\AppUser\Service;

use App\Application\AppUser\DTO\RegisterUserInputDto;
use App\Application\AppUser\DTO\RegisterUserOutputDto;
use App\Application\AppUser\Mapper\AppUserFactory;
use App\Domain\AppUser\Entity\AppUser;
use App\Domain\AppUser\Repository\AppUserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class RegisterUserService
{
    public function __construct(
        private AppUserRepositoryInterface $appUserRepository,
        private JWTTokenManagerInterface $jwtTokenManager,
    ) {
    }

    public function execute(RegisterUserInputDto $registerUserInputDto): RegisterUserOutputDto
    {
        $appUser = AppUserFactory::fromInputDto($registerUserInputDto);

        $existingUser = $this->appUserRepository->findByEmail($appUser->getEmail());
        if ($existingUser instanceof AppUser) {
            return RegisterUserOutputDto::createFromDuplicated($appUser);
        }

        $this->appUserRepository->save($appUser);

        $token = $this->jwtTokenManager->create($appUser);

        return RegisterUserOutputDto::createFromRegister($appUser, $token);
    }
}
