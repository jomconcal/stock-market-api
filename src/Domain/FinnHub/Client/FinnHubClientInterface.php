<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Client;

use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\Exception\FinnHubConnectionException;
use App\Domain\FinnHub\VO\Ticker;

interface FinnHubClientInterface
{
    /**
     * @return array<array-key, mixed>
     *
     * @throws FinnHubConnectionException
     */
    public function doQuoteRequest(string $symbol): array;

    public function fetchQuote(Ticker $ticker): QuoteEntity;
}
