<?php

namespace App\Tests\Unit\FinnHub;

use App\Application\FinnHub\Mapper\GlobalQuote\QuoteResponseMapper;
use App\Application\Parser\ValueParser;
use App\Domain\FinnHub\VO\Ticker;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

class ResponseMapperTest extends TestCase
{
    public function testMapResponseToDTO(): void
    {
        $ticker = Ticker::create('AAPL');
        $response = $this->createResponse();
        $quoteDTO = QuoteResponseMapper::fromApi($response, $ticker);

        $realResponse = $quoteDTO->toArray();
        $expectedResponse = $this->expectedResponse($ticker);

        assertSame($expectedResponse, $realResponse);
    }

    private function createResponse(): array
    {
        $json = file_get_contents(__DIR__.'/Fixtures/quotes_data.json');

        return json_decode($json, true);
    }

    private function expectedResponse(Ticker $ticker): array
    {
        $data = $this->createResponse();

        $currentPrice = ValueParser::toFloat($data['c']);
        $priceChange = ValueParser::toFloat($data['d']);
        $changePercent = ValueParser::toFloat($data['dp']);
        $high = ValueParser::toFloat($data['h']);
        $low = ValueParser::toFloat($data['l']);
        $open = ValueParser::toFloat($data['o']);
        $previousClose = ValueParser::toFloat($data['pc']);
        $timeStamp = ValueParser::toString($data['t']);
        $lastUpdate = \DateTimeImmutable::createFromFormat('U', $timeStamp);

        return [
            'company_name' => $ticker->getCompanyName(),
            'symbol' => $ticker->getSymbol(),
            'current_price' => $currentPrice,
            'price_change' => $priceChange,
            'change_percent' => $changePercent,
            'high' => $high,
            'low' => $low,
            'open' => $open,
            'previous_close' => $previousClose,
            'last_update' => $lastUpdate->format('Y-m-d H:i:s'),
        ];
    }
}
