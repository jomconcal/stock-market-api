<?php

declare(strict_types=1);

namespace App\Infrastructure\AlphaVantage\Client;

use App\Domain\AlphaVantage\Client\AlphaVantageClientInterface;
use App\Domain\AlphaVantage\Enum\AlphaVantageFunction;
use App\Domain\AlphaVantage\Exception\AlphaVantageConnectionException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class AlphaVantageClient implements AlphaVantageClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey,
    ) {
    }

    /**
     * @return array<array-key, mixed>
     *
     * @throws AlphaVantageConnectionException
     */
    #[\Override]
    public function doGlobalQuoteRequest(string $symbol): array
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://www.alphavantage.co/query',
                [
                    'query' => [
                        'function' => AlphaVantageFunction::GLOBAL_QUOTE->value,
                        'symbol' => strtoupper($symbol),
                        'apikey' => $this->apiKey,
                    ],
                ]
            );

            return $response->toArray();
        } catch (\Throwable $e) {
            throw AlphaVantageConnectionException::create($e->getMessage(), (int) $e->getCode(), $e);
        }
    }
}
