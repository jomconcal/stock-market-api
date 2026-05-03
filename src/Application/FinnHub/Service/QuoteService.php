<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Service;

use App\Application\FinnHub\Mapper\GlobalQuote\QuoteDtoMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\QuoteEntityMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\QuoteResponseMapper;
use App\Application\FinnHub\Response\QuoteResponse;
use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\Repository\QuoteRepositoryInterface;
use App\Domain\FinnHub\VO\Symbol;

readonly class QuoteService
{
    public function __construct(
        private FinnHubClientInterface $client,
        private QuoteRepositoryInterface $globalQuoteRepository,
        //        private FinnHubLogRepositoryInterface  $finnHubLogRepository,
        //        private LoggerInterface                $logger,
    ) {
    }

    public function execute(string $symbol): QuoteResponse
    {
        $symbolVO = Symbol::create($symbol);

        $existingQuote = $this->globalQuoteRepository->findWithinLast15Minutes($symbol);

        if ($existingQuote instanceof \App\Domain\FinnHub\Entity\QuoteEntity) {
            $quoteEntity = QuoteDtoMapper::fromEntity($existingQuote);

            return QuoteResponse::createFromCache($quoteEntity);
        }

        $rawResponse = $this->client->doQuoteRequest($symbol);

        // test sobre si aunque pase el threshold de 15 minutos guarda una que ya exista porque la bolsa está cerrada y la última se guardó hace más días.

        $quoteDto = QuoteResponseMapper::fromApi($rawResponse, $symbolVO);

        $quoteEntity = QuoteEntityMapper::fromDto($quoteDto);

        $this->globalQuoteRepository->save($quoteEntity);

        return QuoteResponse::createFromProvider($quoteDto);
    }
}
