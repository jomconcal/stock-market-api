<?php

namespace App\Infrastructure\AlphaVantage\Client;

use App\Infrastructure\AlphaVantage\Factory\GlobalQuoteFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class AlphaVantageClient
{
    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey
    )
    {
    }

    public function doGlobalQuoteRequest(string $symbol): array
    {
        $response = $this->client->request(
            'GET',
            'https://www.alphavantage.co/query',
            [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => strtoupper($symbol),
                'apikey' => $this->apiKey
            ]
        );

        return $response->toArray();
    }
}
