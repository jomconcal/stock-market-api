<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\DTO;

use App\Domain\FinnHub\VO\Symbol;

readonly class QuoteDto
{
    private function __construct(
        private Symbol $symbol,
        private float $currentPrice,
        private float $priceChange,
        private float $changePercent,
        private float $high,
        private float $low,
        private float $open,
        private float $previousClose,
        private \DateTimeImmutable $lastUpdate,
    ) {
    }

    public static function create(
        Symbol $symbol,
        float $currentPrice,
        float $priceChange,
        float $changePercent,
        float $high,
        float $low,
        float $open,
        float $previousClose,
        \DateTimeImmutable $lastUpdate,
    ): self {
        return new self(
            $symbol,
            $currentPrice,
            $priceChange,
            $changePercent,
            $high,
            $low,
            $open,
            $previousClose,
            $lastUpdate,
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'symbol' => $this->symbol->value(),
            'current_price' => $this->currentPrice,
            'price_change' => $this->priceChange,
            'change_percent' => $this->changePercent,
            'high' => $this->high,
            'low' => $this->low,
            'open' => $this->open,
            'previous_close' => $this->previousClose,
            'last_update' => $this->lastUpdate->format('Y-m-d H:i:s'),
        ];
    }

    public function getSymbol(): Symbol
    {
        return $this->symbol;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    public function getPriceChange(): float
    {
        return $this->priceChange;
    }

    public function getChangePercent(): float
    {
        return $this->changePercent;
    }

    public function getPreviousClose(): float
    {
        return $this->previousClose;
    }

    public function getLastUpdate(): \DateTimeImmutable
    {
        return $this->lastUpdate;
    }
}
