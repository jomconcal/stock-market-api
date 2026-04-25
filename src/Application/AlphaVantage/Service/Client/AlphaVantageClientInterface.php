<?php

namespace App\Application\AlphaVantage\Service\Client;

use App\Application\AlphaVantage\Exception\AlphaVantageConnectionException;

interface AlphaVantageClientInterface
{
    /**
     * @return array<array-key, mixed>
     *
     * @throws AlphaVantageConnectionException
     */
    public function doGlobalQuoteRequest(string $symbol): array;
}
