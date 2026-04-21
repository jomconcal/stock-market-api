<?php

namespace App\Presentation\AlphaVantage\GlobalQuote\Controller;

use App\Application\AlphaVantage\Service\GlobalQuoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class GlobalQuoteController extends AbstractController
{
    public function __construct(
        private readonly GlobalQuoteService $globalQuoteService,
    ) {
    }

    #[Route('/stocks-market-api/global-quote/{symbol}', methods: ['GET'])]
    public function getGlobalQuote(string $symbol): JsonResponse
    {
        $stock = $this->globalQuoteService->execute($symbol);

        return $this->json(
            $stock->toArray(),
        );
    }
}
