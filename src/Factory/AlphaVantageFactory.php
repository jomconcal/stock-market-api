<?php

namespace App\Factory;

class AlphaVantageFactory
{
    public function __construct(
        private string $apiKey,
    )
    {

    }

    public function createGlobalQuoteRequest(string $symbol): array
    {
        return [
            'method' => 'GET',
            'url' => 'https://www.alphavantage.co/query',
            'query' => [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => strtoupper($symbol),
                'apikey' => $this->apiKey
            ]
        ];
    }
}
