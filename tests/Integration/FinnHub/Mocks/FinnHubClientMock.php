<?php

namespace App\Tests\Integration\FinnHub\Mocks;

use App\Domain\FinnHub\Client\FinnHubClientInterface;

class FinnHubClientMock implements FinnHubClientInterface
{
    #[\Override]
    public function doQuoteRequest(string $symbol): array
    {
        $json = file_get_contents(__DIR__.'/../Fixtures/quotes_data.json');

        return json_decode($json, true);
    }
}
