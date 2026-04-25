<?php

namespace App\Tests\Mocks;

use App\Application\AlphaVantage\Service\Client\AlphaVantageClientInterface;

class AlphaVantageClientMock implements AlphaVantageClientInterface
{
    private readonly string $latestTradingDay;

    public function __construct(
    ) {
        $this->latestTradingDay = new \DateTime('yesterday')->format('Y-m-d');
    }

    #[\Override]
    public function doGlobalQuoteRequest(string $symbol): array
    {
        return [
            'Global Quote' => [
                '01. symbol' => $symbol,
                '02. open' => '231.9300',
                '03. high' => '232.7999',
                '04. low' => '225.0000',
                '05. price' => '231.9800',
                '06. volume' => '9816859',
                '07. latest trading day' => $this->latestTradingDay,
                '08. previous close' => '231.0800',
                '09. change' => '0.9000',
                '10. change percent' => '0.3895%',
            ],
        ];
    }

    public function getLatestTradingDay(): string
    {
        return $this->latestTradingDay;
    }
}
