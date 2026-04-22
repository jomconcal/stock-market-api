<?php

namespace App\Infrastructure\AlphaVantage\Mapper\GlobalQuote;

use App\Application\AlphaVantage\DTO\GlobalQuoteDto;

class GlobalQuoteResponseMapper
{
    /**
     * @param array<string, mixed> $array
     */
    public static function fromApi(array $array): GlobalQuoteDto
    {
        $quote = $array['Global Quote'];
        $symbol = $quote['01. symbol'];
        $open = (float) $quote['02. open'];
        $high = (float) $quote['03. high'];
        $low = (float) $quote['04. low'];
        $price = (float) $quote['05. price'];
        $volume = (int) $quote['06. volume'];
        $latestTradingDay = $quote['07. latest trading day'];
        $previousClose = (float) $quote['08. previous close'];
        $change = (float) $quote['09. change'];
        $changePercent = $quote['10. change percent'];
        $rawResponse = json_encode($array);

        return GlobalQuoteDto::create(
            $symbol,
            $open,
            $high,
            $low,
            $price,
            $volume,
            $latestTradingDay,
            $previousClose,
            $change,
            $changePercent,
            $rawResponse
        );
    }
}
