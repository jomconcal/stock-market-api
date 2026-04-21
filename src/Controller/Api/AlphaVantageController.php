<?php

namespace App\Controller\Api;

use App\Service\AlphaVantageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class AlphaVantageController extends AbstractController
{

    public function __construct(
        private readonly AlphaVantageService $alphaVantageService
    )
    {

    }

    #[Route('/api/stocks/{symbol}', methods: ['GET'])]
    public function getGlobalQuote(string $symbol): JsonResponse
    {
        $stock = $this->alphaVantageService->executeGlobalQuote($symbol);
        return $this->json(
            $stock->toArray(),
        );
    }
}
