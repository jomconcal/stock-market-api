<?php

declare(strict_types=1);

namespace App\Presentation\FinnHub\GlobalQuote\Controller;

use App\Application\FinnHub\Service\QuoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class QuoteController extends AbstractController
{
    public function __construct(
        private readonly QuoteService $globalQuoteService,
    ) {
    }

    #[Route('/stocks-market-api/quote/{symbol}', methods: ['GET'])]
    public function getQuote(string $symbol): JsonResponse
    {
        $globalQuoteResponse = $this->globalQuoteService->execute($symbol);

        return $this->json(
            $globalQuoteResponse->getSuccess(),
        );
    }
}
