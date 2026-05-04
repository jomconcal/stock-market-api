<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\DTO;

use App\Domain\FinnHub\VO\Ticker;

readonly class QuoteDto
{
    private function __construct(
        private Ticker $ticker,
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
        Ticker $ticker,
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
            $ticker,
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
            'symbol' => $this->ticker->getSymbol(),
            'company_name' => $this->ticker->getCompanyName(),
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

    public function getTicker(): Ticker
    {
        return $this->ticker;
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
