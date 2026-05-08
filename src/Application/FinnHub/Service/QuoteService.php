<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Service;

use App\Application\FinnHub\DTO\QuoteDto;
use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\Repository\QuoteRepositoryInterface;
use App\Domain\FinnHub\VO\Ticker;

readonly class QuoteService
{
    public function __construct(
        private FinnHubClientInterface $client,
        private QuoteRepositoryInterface $globalQuoteRepository,
    ) {
    }

    public function execute(string $symbol): QuoteDto
    {
        $ticker = Ticker::create($symbol);

        $recentQuoteEntity = $this->globalQuoteRepository->findWithinLast15Minutes($ticker->getSymbol());

        if ($recentQuoteEntity instanceof QuoteEntity) {
            return QuoteDto::createFromCache($recentQuoteEntity);
        }

        $quoteEntity = $this->client->fetchQuote($ticker);

        $existingQuoteEntity = $this->getExistingPreviousQuote($quoteEntity, $ticker);

        if ($existingQuoteEntity instanceof QuoteEntity) {
            $this->globalQuoteRepository->updateQuote($existingQuoteEntity);

            return QuoteDto::createFromUpdate($existingQuoteEntity);
        }

        $this->globalQuoteRepository->save($quoteEntity);

        return QuoteDto::createFromProvider($quoteEntity);
    }

    public function getExistingPreviousQuote(QuoteEntity $quoteEntity, Ticker $ticker): ?QuoteEntity
    {
        $lastUpdate = $quoteEntity->getLastUpdate();

        return $this->globalQuoteRepository->findBySymbolAndLastUpdate($ticker->getSymbol(), $lastUpdate);
    }
}
