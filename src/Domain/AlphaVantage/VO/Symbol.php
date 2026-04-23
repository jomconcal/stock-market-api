<?php

namespace App\Domain\AlphaVantage\VO;

final class Symbol
{
    /**
     * @var array<string>
     */
    private const array ALLOWED = [
        'AAPL',
    ];

    private function __construct(private readonly string $value)
    {
    }

    public static function create($symbol):self
    {
        $value = strtoupper($symbol);

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
