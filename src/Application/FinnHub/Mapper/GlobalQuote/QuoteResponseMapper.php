<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Mapper\GlobalQuote;

use App\Application\Parser\ValueParser;
use App\Domain\FinnHub\DTO\QuoteDto;
use App\Domain\FinnHub\Exception\FinnHubLimitException;

final class QuoteResponseMapper
{
    /**
     * @param array<array-key, mixed> $data
     *
     * @throws FinnHubLimitException
     */
    public static function fromApi(array $data, string $symbol): QuoteDto
    {

        $currentPrice = ValueParser::toFloat($data['c']);
        $change = ValueParser::toFloat($data['d']);
        $changePercent = ValueParser::toFloat($data['dp']);
        $high = ValueParser::toFloat($data['h']);
        $low = ValueParser::toFloat($data['l']);
        $open = ValueParser::toFloat($data['o']);
        $previousClose = ValueParser::toFloat($data['pc']);
        $timeStamp = ValueParser::toString($data['t']);
        $lastUpdate = \DateTimeImmutable::createFromFormat('U', $timeStamp);

        $rawResponse = json_encode($data);

        if (false === $rawResponse) {
            throw new \RuntimeException('Failed to encode raw response');
        }

        return QuoteDto::create(
            $symbol,
            $currentPrice,
            $change,
            $changePercent,
            $high,
            $low,
            $open,
            $previousClose,
            $lastUpdate,
        );
    }
}
