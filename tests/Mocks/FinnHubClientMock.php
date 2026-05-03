<?php

namespace App\Tests\Mocks;

use App\Domain\FinnHub\Client\FinnHubClientInterface;

class FinnHubClientMock implements FinnHubClientInterface
{
    private readonly string $latestTradingDay;

    public function __construct(
    ) {
        $this->latestTradingDay = new \DateTime('yesterday')->format('Y-m-d');
    }

    #[\Override]
    public function doGlobalQuoteRequest(string $symbol): array
    {
        $timestamp = (new \DateTimeImmutable($this->latestTradingDay))->getTimestamp();

        return [
            'symbol' => $symbol,
            'c' => 231.9800,
            'd' => 0.9000,
            'dp' => 0.3895,
            'h' => 232.7999,
            'l' => 225.0000,
            'o' => 231.9300,
            'pc' => 231.0800,
            't' => $timestamp,
        ];
    }

    public function getLatestTradingDay(): string
    {
        return $this->latestTradingDay;
    }
}
