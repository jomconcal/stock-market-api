<?php

namespace App\Presentation\AlphaVantage\GlobalQuote\Controller;

use App\Application\AlphaVantage\Response\GlobalQuoteResponse;
use App\Application\AlphaVantage\Service\GlobalQuoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class GlobalQuoteController extends AbstractController
{
    public function __construct(
        private readonly GlobalQuoteService $globalQuoteService,
    )
    {
    }

    #[Route('/stocks-market-api/global-quote/{symbol}', methods: ['GET'])]
    public function getGlobalQuote(string $symbol): JsonResponse
    {
        try {
            $globalQuoteResponse = $this->globalQuoteService->execute($symbol);

            if ($globalQuoteResponse->isError()) {
                return $this->json(
                    $globalQuoteResponse->getError(),
                );
            }

            return $this->json(
                $globalQuoteResponse->getSuccess(),
            );
        } catch (\Throwable $exception) {
           $response = GlobalQuoteResponse::createWithError($exception->getMessage());

            return $this->json(
               $response->getError(),
            );
        }
    }
}
