<?php

declare(strict_types=1);

namespace App\Presentation\AppUser\Register\Controller;

use App\Application\AppUser\DTO\RegisterUserInputDto;
use App\Application\AppUser\Service\RegisterUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class RegisterAppUserController extends AbstractController
{
    public function __construct(
        private readonly RegisterUserService $registerUserService,
    ) {
    }

    #[Route('/stocks-market-api/resgiter/', methods: ['POST'])]
    public function postNewAppUser(
        #[MapRequestPayload]
        RegisterUserInputDto $registerUserInputDto,
    ): JsonResponse {
        $outputDto = $this->registerUserService->execute($registerUserInputDto);

        return $this->json($outputDto);
    }
}
