<?php

declare(strict_types=1);

namespace App\Infrastructure\FinnHub\Client;

use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\Exception\FinnHubConnectionException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class FinnHubClient implements FinnHubClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey,
    ) {
    }

    /**
     * @return array<array-key, mixed>
     *
     * @throws FinnHubConnectionException
     */
    #[\Override]
    public function doQuoteRequest(string $symbol): array
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://finnhub.io/api/v1/quote',
                [
                    'query' => [
                        'symbol' => strtoupper($symbol),
                        'token' => $this->apiKey,
                    ],
                ]
            );

            return $response->toArray();
        } catch (\Throwable $e) {
            throw FinnHubConnectionException::create($e->getMessage(), $e);
        }
    }
}
