<?php

namespace App\Tests\Integration\FinnHub\Mocks;

use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\VO\Ticker;

class FinnHubClientMock implements FinnHubClientInterface
{
    #[\Override]
    public function doQuoteRequest(string $symbol): array
    {
        $json = file_get_contents(__DIR__.'/../Fixtures/quotes_data.json');

        return json_decode($json, true);
    }

    #[\Override]
    public function fetchQuote(Ticker $ticker): QuoteEntity
    {
        $data = $this->doQuoteRequest($ticker->getSymbol());

        $currentPrice = $data['c'];
        $change = $data['d'];
        $changePercent = $data['dp'];
        $high = $data['h'];
        $low = $data['l'];
        $open = $data['o'];
        $previousClose = $data['pc'];
        $timeStamp = $data['t'];
        $lastUpdate = \DateTimeImmutable::createFromFormat('U', $timeStamp);

        if (false === $lastUpdate) {
            throw new \RuntimeException('Invalid date format: '.$timeStamp);
        }

        return new QuoteEntity(
            symbol: $ticker->getSymbol(),
            companyName: $ticker->getCompanyName(),
            currentPrice: $currentPrice,
            priceChange: $change,
            changePercent: $changePercent,
            high: $high,
            low: $low,
            open: $open,
            previousClose: $previousClose,
            lastUpdate: $lastUpdate,
        );
    }
}
