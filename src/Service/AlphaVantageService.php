<?php

namespace App\Service;

use App\Client\AlphaVantageClient;
use App\DTO\GlobalQuoteDTO;
use App\Mapper\AlphaVantageMapper;
use App\Repository\GlobalQuoteRepository;

readonly class AlphaVantageService
{
    public function __construct(
        private AlphaVantageClient    $client,
        private GlobalQuoteRepository $globalQuoteRepository,
    )
    {

    }
    public function executeGlobalQuote(string $symbol): GlobalQuoteDTO
    {
        $date = new \DateTimeImmutable('today')->format('Y-m-d');

        $globalQuoteEntity = $this->globalQuoteRepository->findByLastFetchedAndSymbol($symbol,$date);

        if($globalQuoteEntity){
            return AlphaVantageMapper::createGlobalQuoteDtoFromEntity($globalQuoteEntity);
        }

        $response = $this->client->doGlobalQuoteRequest($symbol);
        $globalQuoteDTO= AlphaVantageMapper::mapGlobalQuote($response);
        $globalQuoteEntity= AlphaVantageMapper::createGlobalQuoteEntityFromDto($globalQuoteDTO);

        $this->globalQuoteRepository->save($globalQuoteEntity);
        return $globalQuoteDTO;
    }
}
