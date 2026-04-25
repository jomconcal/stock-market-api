<?php

namespace App\Domain\AlphaVantage\Client;

use App\Domain\AlphaVantage\Exception\AlphaVantageConnectionException;

interface AlphaVantageClientInterface
{
    /**
     * @return array<array-key, mixed>
     *
     * @throws AlphaVantageConnectionException
     */
    public function doGlobalQuoteRequest(string $symbol): array;
}
