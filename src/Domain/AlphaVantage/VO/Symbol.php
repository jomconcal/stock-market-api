<?php

namespace App\Domain\AlphaVantage\VO;

final class Symbol
{
    /**
     * @var array<string>
     */
    private const array ALLOWED = [
        'AAPL', // Apple Inc.
        'MSFT', // Microsoft
        'GOOG', // Alphabet Inc.
        'AMZN', // Amazon
        'NVDA', // NVIDIA
        'META', // Meta Platforms
        'TSLA', // Tesla
        'TM', // Toyota
        'XOM', // ExxonMobil
        'SHEL', // Shell plc
        'JPM', // JPMorgan Chase
        'GS', // Goldman Sachs
        'V', // Visa
        'KO', // Coca-Cola
        'PEP', // PepsiCo
        'WMT', // Walmart
        'NKE', // Nike
        'ITX.MC', // Inditex
        'SAN.MC', // Banco Santander
        'BBVA.MC', // BBVA
        'IBE.MC', // Iberdrola
    ];

    private function __construct(private readonly string $value)
    {
    }

    public static function create(string $symbol): self
    {
        $value = trim(strtoupper($symbol));

        if (!in_array($value, self::ALLOWED, true)) {
            throw new \InvalidArgumentException("Symbol not allowed: $value");
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
