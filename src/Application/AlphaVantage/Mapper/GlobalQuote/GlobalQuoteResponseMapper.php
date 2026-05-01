<?php

declare(strict_types=1);

namespace App\Application\AlphaVantage\Mapper\GlobalQuote;

use App\Application\Parser\ValueParser;
use App\Domain\AlphaVantage\DTO\GlobalQuoteDto;
use App\Domain\AlphaVantage\Exception\AlphaVantageLimitException;

final class GlobalQuoteResponseMapper
{
    /**
     * @param array<array-key, mixed> $data
     *
     * @throws AlphaVantageLimitException
     */
    public static function fromApi(array $data): GlobalQuoteDto
    {
        if (isset($data['Information'])) {
            throw AlphaVantageLimitException::create();
        }
        if (!isset($data['Global Quote']) || !is_array($data['Global Quote'])) {
            throw new \InvalidArgumentException('Invalid response. Global Quote array missing.');
        }

        /** @var array<string, mixed> $quote */
        $quote = $data['Global Quote'];

        if (!isset($quote['01. symbol'])) {
            throw new \InvalidArgumentException('Invalid response. Symbol missing.');
        }
        $symbol = ValueParser::toString($quote['01. symbol']);
        $open = ValueParser::toFloat($quote['02. open']);
        $high = ValueParser::toFloat($quote['03. high']);
        $low = ValueParser::toFloat($quote['04. low']);
        $price = ValueParser::toFloat($quote['05. price']);
        $volume = ValueParser::toInt($quote['06. volume']);
        $latestTradingDay = ValueParser::toString($quote['07. latest trading day']);
        $previousClose = ValueParser::toFloat($quote['08. previous close']);
        $change = ValueParser::toFloat($quote['09. change']);
        $changePercent = ValueParser::toString($quote['10. change percent']);

        $rawResponse = json_encode($data);

        if (false === $rawResponse) {
            throw new \RuntimeException('Failed to encode raw response');
        }

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
            $changePercent
        );
    }
}
