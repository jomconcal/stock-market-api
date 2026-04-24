<?php

namespace App\Application\AlphaVantage\Service;

use App\Application\AlphaVantage\Response\GlobalQuoteResponse;
use App\Domain\AlphaVantage\Enum\AlphaVantageFunction;
use App\Domain\AlphaVantage\Repository\AlphaVantageLogRepository;
use App\Domain\AlphaVantage\Repository\GlobalQuoteRepository;
use App\Domain\AlphaVantage\VO\Symbol;
use App\Infrastructure\AlphaVantage\Client\AlphaVantageClient;
use App\Infrastructure\AlphaVantage\Factory\AlphaVantageLogFactory;
use App\Infrastructure\AlphaVantage\Mapper\GlobalQuote\GlobalQuoteDtoMapper;
use App\Infrastructure\AlphaVantage\Mapper\GlobalQuote\GlobalQuoteEntityMapper;
use App\Infrastructure\AlphaVantage\Mapper\GlobalQuote\GlobalQuoteResponseMapper;
use Psr\Log\LoggerInterface;

readonly class GlobalQuoteService
{
    public function __construct(
        private AlphaVantageClient $client,
        private GlobalQuoteRepository $globalQuoteRepository,
        private AlphaVantageLogRepository $alphaVantageLogRepository,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $symbol): GlobalQuoteResponse
    {
        $symbolVo = null;
        try {
            $symbolVo = Symbol::create($symbol);
            $globalQuoteEntity = $this->globalQuoteRepository->findByLastFetchedAndSymbol($symbolVo);

            if ($globalQuoteEntity) {
                $globalQuoteDTO = GlobalQuoteDtoMapper::fromEntity($globalQuoteEntity);
                $this->logger->info('Global Quote retrieved from cache', [
                    'symbol' => $symbolVo->value(),
                    'fetched_at' => $globalQuoteEntity->getFetchedAt(),
                ]);

                $alphaVantageLog = AlphaVantageLogFactory::fromCache(
                    $symbolVo,
                    AlphaVantageFunction::GLOBAL_QUOTE,
                    []
                );

                $this->alphaVantageLogRepository->save($alphaVantageLog);

                return GlobalQuoteResponse::createFromCache($globalQuoteDTO);
            }

            $response = $this->client->doGlobalQuoteRequest($symbol);
            $globalQuoteDTO = GlobalQuoteResponseMapper::fromApi($response, $symbolVo);
            $globalQuoteEntity = GlobalQuoteEntityMapper::fromDto($globalQuoteDTO);

            $this->logger->info('Global Quote retrieved from AlphaVantage', [
                'symbol' => $symbol,
                'fetched_at' => $globalQuoteEntity->getFetchedAt(),
            ]);

            $alphaVantageLog = AlphaVantageLogFactory::fromProvider(
                $symbolVo,
                AlphaVantageFunction::GLOBAL_QUOTE,
                $response
            );

            $this->alphaVantageLogRepository->save($alphaVantageLog);
            $this->globalQuoteRepository->save($globalQuoteEntity);

            return GlobalQuoteResponse::createFromProvider($globalQuoteDTO);
        } catch (\Throwable $e) {
            $this->logger->error(
                $e->getMessage(),
                $e->getTrace()
            );

            $symbolValue = $symbolVo?->value() ?? $symbol;
            $alphaVantageLog = AlphaVantageLogFactory::fromError(
                $symbolValue,
                AlphaVantageFunction::GLOBAL_QUOTE,
                $e->getMessage(),
                $e->getTrace()
            );

            $this->alphaVantageLogRepository->save($alphaVantageLog);
            throw $e;
        }
    }
}
