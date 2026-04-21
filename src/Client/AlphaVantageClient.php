<?php

namespace App\Client;

use App\Factory\AlphaVantageFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class AlphaVantageClient
{
    public function __construct(
        private HttpClientInterface $client,
        private AlphaVantageFactory $factory
    )
    {
    }

    public function doGlobalQuoteRequest(string $symbol): array
    {
        $request = $this->factory->createGlobalQuoteRequest($symbol);
        $response = $this->client->request(
            $request['method'],
            $request['url'],
            ['query' => $request['query']]
        );

        return $response->toArray();
    }
}
