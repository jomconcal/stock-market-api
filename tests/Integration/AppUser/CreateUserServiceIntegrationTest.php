<?php

namespace App\Tests\Integration\AppUser;

use App\Application\AppUser\DTO\RegisterUserInputDto;
use App\Application\AppUser\Service\RegisterUserService;
use App\Domain\AppUser\Entity\AppUser;
use App\Domain\AppUser\Repository\AppUserRepositoryInterface;
use App\Domain\AppUser\UserRol;
use App\Infrastructure\AppUser\Persistence\AppUserRepository;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateUserServiceIntegrationTest extends KernelTestCase
{
    private RegisterUserService $createUserService;
    private AppUserRepositoryInterface $appUserRepository;

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();

        $this->appUserRepository = $container->get(AppUserRepository::class);
        $this->createUserService = $container->get(RegisterUserService::class);
    }

    public function testSaveUnexistingUser(): void
    {
        $inputDto = new RegisterUserInputDto(
            email: 'example@example.com',
            password: 'thisIsAPassword_1234',
            name: 'Fulano',
            surname: 'De Tal',
        );

        $outPutDto = $this->createUserService->execute($inputDto);
        self::assertTrue($outPutDto->registered);

        $user = $this->appUserRepository->findByEmail($inputDto->email);
        self::assertNotNull($user);
        self::assertNotSame($inputDto->password, $user->getPassword());
    }

    public function testExistingUserNotSavedAgain(): void
    {
        $appUser = new AppUser(
            'example@example.com',
            'existingPassword',
            'existingName',
            'existingSurname',
            [UserRol::ROLE_USER],
        );
        $this->appUserRepository->save($appUser);

        $inputDto = new RegisterUserInputDto(
            email: 'example@example.com',
            password: 'thisIsAPassword_1234',
            name: 'Fulano',
            surname: 'De Tal',
        );

        $outPutDto = $this->createUserService->execute($inputDto);

        self::assertFalse($outPutDto->registered);
    }
}
