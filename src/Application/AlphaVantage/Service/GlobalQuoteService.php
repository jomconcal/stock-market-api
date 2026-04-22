<?php

namespace App\Application\AlphaVantage\Service;

use App\Application\AlphaVantage\Exception\AlphaVantageConnectionException;
use App\Application\AlphaVantage\Response\GlobalQuoteResponse;
use App\Domain\AlphaVantage\Repository\GlobalQuoteRepository;
use App\Infrastructure\AlphaVantage\Client\AlphaVantageClient;
use App\Infrastructure\AlphaVantage\Mapper\GlobalQuote\GlobalQuoteDtoMapper;
use App\Infrastructure\AlphaVantage\Mapper\GlobalQuote\GlobalQuoteEntityMapper;
use App\Infrastructure\AlphaVantage\Mapper\GlobalQuote\GlobalQuoteResponseMapper;
use Psr\Log\LoggerInterface;

readonly class GlobalQuoteService
{
    public function __construct(
        private AlphaVantageClient $client,
        private GlobalQuoteRepository $globalQuoteRepository,
        private LoggerInterface $logger,
    ) {
    }

    public function execute(string $symbol): GlobalQuoteResponse
    {
        $globalQuoteEntity = $this->globalQuoteRepository->findByLastFetchedAndSymbol($symbol);

        if ($globalQuoteEntity) {
            $globalQuoteDTO = GlobalQuoteDtoMapper::fromEntity($globalQuoteEntity);
            $this->logger->info('Global Quote retrieved from cache', [
                'symbol' => $symbol,
                'fetched_at' => $globalQuoteEntity->getFetchedAt(),
            ]);

            return GlobalQuoteResponse::createFromCache($globalQuoteDTO);
        }

        try {
            $response = $this->client->doGlobalQuoteRequest($symbol);
            $globalQuoteDTO = GlobalQuoteResponseMapper::fromApi($response);
            $globalQuoteEntity = GlobalQuoteEntityMapper::fromDto($globalQuoteDTO);

            $this->logger->info('Global Quote retrieved from AlphaVantage', [
                'symbol' => $symbol,
                'fetched_at' => $globalQuoteEntity->getFetchedAt(),
            ]);

            $this->globalQuoteRepository->save($globalQuoteEntity);

            return GlobalQuoteResponse::createFromProvider($globalQuoteDTO);
        } catch (AlphaVantageConnectionException $e) {
            $this->logger->error(
                $e->getMessage(),
                $e->getTrace()
            );

            return GlobalQuoteResponse::createWithError($e->getMessage());
        }
    }
}
