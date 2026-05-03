<?php

namespace App\Application\FinnHub\Service;

use App\Application\FinnHub\Factory\FinnHubLogFactory;
use App\Application\FinnHub\Mapper\GlobalQuote\GlobalQuoteDtoMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\GlobalQuoteEntityMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\GlobalQuoteResponseMapper;
use App\Application\FinnHub\Response\GlobalQuoteResponse;
use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\DTO\GlobalQuoteDto;
use App\Domain\FinnHub\Entity\GlobalQuoteEntity;
use App\Domain\FinnHub\Enum\FinnHubFunction;
use App\Domain\FinnHub\Repository\FinnHubLogRepositoryInterface;
use App\Domain\FinnHub\Repository\GlobalQuoteRepositoryInterface;
use App\Domain\FinnHub\VO\Symbol;
use Psr\Log\LoggerInterface;

readonly class GlobalQuoteService
{
    public function __construct(
        private FinnHubClientInterface $client,
        private GlobalQuoteRepositoryInterface $globalQuoteRepository,
        private FinnHubLogRepositoryInterface $finnHubLogRepository,
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
            $globalQuoteEntity = $this->globalQuoteRepository->findByFetchedTodayAndSymbol($symbolVo->value());

            if (null != $globalQuoteEntity) {
                $globalQuoteDTO = GlobalQuoteDtoMapper::fromEntity($globalQuoteEntity);
                $this->logger->info('Global Quote retrieved from cache', [
                    'symbol' => $symbolVo->value(),
                    'fetched_at' => $globalQuoteEntity->getFetchedAt(),
                ]);

                $finnHubLog = FinnHubLogFactory::fromCache(
                    $symbolVo,
                    FinnHubFunction::GLOBAL_QUOTE,
                    []
                );

                $this->finnHubLogRepository->save($finnHubLog);

                return GlobalQuoteResponse::createFromCache($globalQuoteDTO);
            }

            $response = $this->client->doGlobalQuoteRequest($symbol);
            $globalQuoteDTO = GlobalQuoteResponseMapper::fromApi($response);
            $globalQuoteEntity = GlobalQuoteEntityMapper::fromDto($globalQuoteDTO);

            $this->logger->info('Global Quote retrieved from FinnHub', [
                'symbol' => $symbol,
                'fetched_at' => $globalQuoteEntity->getFetchedAt(),
            ]);

            $this->saveOrReplaceGlobalQuote($globalQuoteDTO, $symbolVo, $response, $globalQuoteEntity);

            return GlobalQuoteResponse::createFromProvider($globalQuoteDTO);
        } catch (\Throwable $e) {
            $this->logger->error(
                $e->getMessage(),
                $e->getTrace()
            );

            $symbolValue = $symbolVo?->value() ?? $symbol;
            $finnHubLog = FinnHubLogFactory::fromError(
                $symbolValue,
                FinnHubFunction::GLOBAL_QUOTE,
                $e->getMessage(),
                $e->getTrace()
            );

            $this->finnHubLogRepository->save($finnHubLog);
            throw $e;
        }
    }

    private function hasSymbolAndLastTradingDay(
        GlobalQuoteDto $globalQuoteDTO,
    ): bool {
        $symbol = $globalQuoteDTO->getSymbol();
        $latestTradingDay = $globalQuoteDTO->getLatestTradingDay();
        $globalQuoteEntity = $this->globalQuoteRepository->getBySymbolAndLatestTradingDay($symbol, $latestTradingDay);

        return !is_null($globalQuoteEntity);
    }

    /**
     * @param array<array-key, mixed> $response
     */
    public function saveOrReplaceGlobalQuote(
        GlobalQuoteDto $globalQuoteDTO,
        Symbol $symbolVo,
        array $response,
        GlobalQuoteEntity $globalQuoteEntity): void
    {
        if ($this->hasSymbolAndLastTradingDay($globalQuoteDTO)) {
            $finnHubLog = FinnHubLogFactory::fromProvider(
                $symbolVo,
                FinnHubFunction::GLOBAL_QUOTE,
                $response,
                true
            );

            $this->finnHubLogRepository->save($finnHubLog);
            $this->globalQuoteRepository->replace($globalQuoteEntity);

            return;
        }
        $finnHubLog = FinnHubLogFactory::fromProvider(
            $symbolVo,
            FinnHubFunction::GLOBAL_QUOTE,
            $response
        );

        $this->finnHubLogRepository->save($finnHubLog);
        $this->globalQuoteRepository->save($globalQuoteEntity);
    }
}
