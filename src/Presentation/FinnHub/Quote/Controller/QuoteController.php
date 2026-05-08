<?php

declare(strict_types=1);

namespace App\Presentation\FinnHub\Quote\Controller;

use App\Application\FinnHub\Service\QuoteService;
use App\Presentation\StatusCode\HTTP_CODE;
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
        try {
            $quoteDto = $this->globalQuoteService->execute($symbol);

            return $this->json(
                [
                    'status' => 'SUCCESS',
                    'code' => HTTP_CODE::SUCCESS,
                    'quote' => $quoteDto->toArray(),
                ]
            );
        } catch (\Throwable $e) {
            return $this->json(
                [
                    'status' => 'ERROR',
                    'code' => HTTP_CODE::INTERNAL_SERVER_ERROR,
                    'quote' => [],
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
}
