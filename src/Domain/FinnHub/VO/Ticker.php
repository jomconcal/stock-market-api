<?php

namespace App\Domain\FinnHub\VO;

final class Ticker
{
    /**
     * @var array<string, string>
     */
    private const array COMPANIES = [
        'AAPL' => 'Apple Inc.',
        'MSFT' => 'Microsoft Corporation',
        'GOOG' => 'Alphabet Inc.',
        'AMZN' => 'Amazon.com Inc.',
        'NVDA' => 'NVIDIA Corporation',
        'META' => 'Meta Platforms Inc.',
        'TSLA' => 'Tesla Inc.',
        'TM' => 'Toyota Motor Corporation',
        'XOM' => 'Exxon Mobil Corporation',
        'SHEL' => 'Shell plc',
        'JPM' => 'JPMorgan Chase & Co.',
        'GS' => 'The Goldman Sachs Group Inc.',
        'V' => 'Visa Inc.',
        'KO' => 'The Coca-Cola Company',
        'PEP' => 'PepsiCo Inc.',
        'WMT' => 'Walmart Inc.',
        'NKE' => 'Nike Inc.',
    ];

    private function __construct(
        private readonly string $value,
        private readonly string $companyName,
    ) {
    }

    public static function create(string $symbol): self
    {
        $value = trim(strtoupper($symbol));

        if (!array_key_exists($value, self::COMPANIES)) {
            throw new \InvalidArgumentException("Symbol not allowed: $value");
        }

        $companyName = self::COMPANIES[$value];

        return new self($value, $companyName);
    }

    public function getSymbol(): string
    {
        return $this->value;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
