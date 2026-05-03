<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Client;

use App\Domain\FinnHub\Exception\FinnHubConnectionException;

interface FinnHubClientInterface
{
    /**
     * @return array<array-key, mixed>
     *
     * @throws FinnHubConnectionException
     */
    public function doQuoteRequest(string $symbol): array;
}
