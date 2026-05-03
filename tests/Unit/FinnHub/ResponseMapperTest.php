<?php

namespace App\Tests\Unit\FinnHub;

use App\Application\FinnHub\Mapper\GlobalQuote\QuoteResponseMapper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class ResponseMapperTest extends TestCase
{
    public function testMapResponseToDTO(): void
    {
        $symbol = 'AAPL';
        $response = $this->createResponse();
        $quoteDTO = QuoteResponseMapper::fromApi($response,$symbol);

        $realResponse = $quoteDTO->toArray();
        $expectedResponse = $this->expectedResponse($symbol);

        assertSame($expectedResponse, $realResponse);
    }

    private function createResponse(): array
    {
        $json = file_get_contents(__DIR__.'/Fixtures/quotes_data.json');
        $data = json_decode($json, true);

        return $data;
    }

    private function expectedResponse(string $symbol): array
    {
        return [
            'symbol' => $symbol,
            'current_price' => 280.16,
            'change' => 8.81,
            'change_percent' => 3.2467,
            'high' => 287.22,
            'low' => 278.37,
            'open' => 278.865,
            'previous_close' => 271.35,
            'last_update' => date('Y-m-d H:i:s', 1777665600),
        ];
    }
}
