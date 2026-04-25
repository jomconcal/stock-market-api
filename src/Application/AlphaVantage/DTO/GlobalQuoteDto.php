<?php

namespace App\Application\AlphaVantage\DTO;

readonly class GlobalQuoteDto
{
    private function __construct(
        private string $symbol,
        private float $open,
        private float $high,
        private float $low,
        private float $price,
        private int $volume,
        private string $latestTradingDay,
        private float $previousClose,
        private float $change,
        private string $changePercent,
    ) {
    }

    public static function create(
        string $symbol,
        float $open,
        float $high,
        float $low,
        float $price,
        int $volume,
        string $latestTradingDay,
        float $previousClose,
        float $change,
        string $changePercent,
    ): self {
        return new self(
            $symbol,
            $open,
            $high,
            $low,
            $price,
            $volume,
            $latestTradingDay,
            $previousClose,
            $change,
            $changePercent
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'symbol' => $this->symbol,
            'open' => $this->open,
            'high' => $this->high,
            'low' => $this->low,
            'price' => $this->price,
            'volume' => $this->volume,
            'latestTradingDay' => $this->latestTradingDay,
            'previousClose' => $this->previousClose,
            'change' => $this->change,
            'changePercent' => $this->changePercent,
        ];
    }

    public function getSymbol(): string
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function getLatestTradingDay(): string
    {
        return $this->latestTradingDay;
    }

    public function getPreviousClose(): float
    {
        return $this->previousClose;
    }

    public function getChange(): float
    {
        return $this->change;
    }

    public function getChangePercent(): string
    {
        return $this->changePercent;
    }
}
