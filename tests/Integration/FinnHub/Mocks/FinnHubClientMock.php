<?php

namespace App\Tests\Integration\FinnHub\Mocks;

use App\Domain\FinnHub\Client\FinnHubClientInterface;
use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\VO\Ticker;
use App\Infrastructure\Parser\ValueParser;

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

        $currentPrice = ValueParser::toFloat($data['c']);
        $change = ValueParser::toFloat($data['d']);
        $changePercent = ValueParser::toFloat($data['dp']);
        $high = ValueParser::toFloat($data['h']);
        $low = ValueParser::toFloat($data['l']);
        $open = ValueParser::toFloat($data['o']);
        $previousClose = ValueParser::toFloat($data['pc']);
        $timeStamp = ValueParser::toString($data['t']);
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
