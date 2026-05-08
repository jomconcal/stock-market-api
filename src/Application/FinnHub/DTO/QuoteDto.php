<?php

namespace App\Application\FinnHub\DTO;

use App\Domain\FinnHub\Entity\QuoteEntity;

class QuoteDto
{
    private const string CACHE = 'CACHE';
    private const string PROVIDER = 'FINN_HUB';
    private const string UPDATE = 'UPDATE';

    private function __construct(
        public string $symbol,
        public string $companyName,
        public float $currentPrice,
        public float $priceChange,
        public float $changePercent,
        public float $high,
        public float $low,
        public float $open,
        public float $previousClose,
        public \DateTimeImmutable $lastUpdate,
        public \DateTimeInterface $fetchedAt,
        public string $source,
    ) {
    }

    public static function createFromProvider(QuoteEntity $quoteEntity): self
    {
        return new self(
            symbol: $quoteEntity->getSymbol(),
            companyName: $quoteEntity->getCompanyName(),
            currentPrice: $quoteEntity->getCurrentPrice(),
            priceChange: $quoteEntity->getPriceChange(),
            changePercent: $quoteEntity->getChangePercent(),
            high: $quoteEntity->getHigh(),
            low: $quoteEntity->getLow(),
            open: $quoteEntity->getOpen(),
            previousClose: $quoteEntity->getPreviousClose(),
            lastUpdate: $quoteEntity->getLastUpdate(),
            fetchedAt: $quoteEntity->getFetchedAt(),
            source: self::PROVIDER,
        );
    }

    public static function createFromCache(QuoteEntity $quoteEntity): self
    {
        return new self(
            symbol: $quoteEntity->getSymbol(),
            companyName: $quoteEntity->getCompanyName(),
            currentPrice: $quoteEntity->getCurrentPrice(),
            priceChange: $quoteEntity->getPriceChange(),
            changePercent: $quoteEntity->getChangePercent(),
            high: $quoteEntity->getHigh(),
            low: $quoteEntity->getLow(),
            open: $quoteEntity->getOpen(),
            previousClose: $quoteEntity->getPreviousClose(),
            lastUpdate: $quoteEntity->getLastUpdate(),
            fetchedAt: $quoteEntity->getFetchedAt(),
            source: self::CACHE,
        );
    }

    public static function createFromUpdate(QuoteEntity $quoteEntity): self
    {
        return new self(
            symbol: $quoteEntity->getSymbol(),
            companyName: $quoteEntity->getCompanyName(),
            currentPrice: $quoteEntity->getCurrentPrice(),
            priceChange: $quoteEntity->getPriceChange(),
            changePercent: $quoteEntity->getChangePercent(),
            high: $quoteEntity->getHigh(),
            low: $quoteEntity->getLow(),
            open: $quoteEntity->getOpen(),
            previousClose: $quoteEntity->getPreviousClose(),
            lastUpdate: $quoteEntity->getLastUpdate(),
            fetchedAt: $quoteEntity->getFetchedAt(),
            source: self::UPDATE,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'symbol' => $this->symbol,
            'companyName' => $this->companyName,
            'currentPrice' => $this->currentPrice,
            'priceChange' => $this->priceChange,
            'changePercent' => $this->changePercent,
            'high' => $this->high,
            'low' => $this->low,
            'open' => $this->open,
            'previousClose' => $this->previousClose,
            'lastUpdate' => $this->lastUpdate->format('Y-m-d H:i:s'),
            'fetchedAt' => $this->fetchedAt->format('Y-m-d H:i:s'),
            'source' => $this->source,
        ];
    }
}
