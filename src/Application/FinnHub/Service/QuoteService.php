<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Service;

use App\Application\FinnHub\Mapper\GlobalQuote\QuoteDtoMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\QuoteEntityMapper;
use App\Application\FinnHub\Mapper\GlobalQuote\QuoteResponseMapper;
use App\Application\FinnHub\Response\QuoteResponse;
use App\Application\Parser\ValueParser;
use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\Repository\QuoteRepositoryInterface;
use App\Domain\FinnHub\VO\Ticker;

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
        $ticker = Ticker::create($symbol);

        $recentQuoteEntity = $this->globalQuoteRepository->findWithinLast15Minutes($symbol);

        if ($recentQuoteEntity instanceof QuoteEntity) {
            $quoteDto = QuoteDtoMapper::fromEntity($recentQuoteEntity);

            return QuoteResponse::createFromCache($quoteDto);
        }

        $rawResponse = $this->client->doQuoteRequest($symbol);

        $existingQuoteEntity = $this->getExistingPreviousQuote($rawResponse, $symbol);

        if ($existingQuoteEntity instanceof QuoteEntity) {
            $this->globalQuoteRepository->updateQuote($existingQuoteEntity);

            return QuoteResponse::createFromUpdate(QuoteDtoMapper::fromEntity($existingQuoteEntity));
        }

        $quoteDto = QuoteResponseMapper::fromApi($rawResponse, $ticker);

        $quoteEntity = QuoteEntityMapper::fromDto($quoteDto);

        $this->globalQuoteRepository->save($quoteEntity);

        return QuoteResponse::createFromProvider($quoteDto);
    }

    /**
     * @param array<array-key,mixed> $rawResponse
     */
    public function getExistingPreviousQuote(array $rawResponse, string $symbol): ?QuoteEntity
    {
        $timeStamp = ValueParser::toString($rawResponse['t']);
        $lastUpdate = \DateTimeImmutable::createFromFormat('U', $timeStamp);
        if (false === $lastUpdate) {
            throw new \RuntimeException('Invalid date format: '.$timeStamp);
        }

        return $this->globalQuoteRepository->findBySymbolAndLastUpdate($symbol, $lastUpdate);
    }
}
