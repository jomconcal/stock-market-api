<?php

namespace App\Application\AlphaVantage\Service;

use App\Application\AlphaVantage\DTO\GlobalQuoteDTO;
use App\Domain\AlphaVantage\Repository\GlobalQuoteRepository;
use App\Infrastructure\AlphaVantage\Client\AlphaVantageClient;
use App\Infrastructure\AlphaVantage\Factory\GlobalQuoteFactory;
use App\Infrastructure\AlphaVantage\Mapper\GlobalQuoteMapper;

readonly class GlobalQuoteService
{
    public function __construct(
        private AlphaVantageClient $client,
        private GlobalQuoteRepository $globalQuoteRepository,
    ) {
    }

    public function execute(string $symbol): GlobalQuoteDTO
    {
        $date = new \DateTimeImmutable('today')->format('Y-m-d');

        $globalQuoteEntity = $this->globalQuoteRepository->findByLastFetchedAndSymbol($symbol);

        if ($globalQuoteEntity) {
            return GlobalQuoteFactory::createGlobalQuoteDtoFromEntity($globalQuoteEntity);
        }

        $response = $this->client->doGlobalQuoteRequest($symbol);
        $globalQuoteDTO = GlobalQuoteMapper::mapGlobalQuote($response);
        $globalQuoteEntity = GlobalQuoteFactory::createGlobalQuoteEntityFromDto($globalQuoteDTO);

        $this->globalQuoteRepository->save($globalQuoteEntity);

        return $globalQuoteDTO;
    }
}
