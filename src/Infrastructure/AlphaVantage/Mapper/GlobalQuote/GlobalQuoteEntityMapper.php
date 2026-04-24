<?php

namespace App\Infrastructure\AlphaVantage\Mapper\GlobalQuote;

use App\Application\AlphaVantage\DTO\GlobalQuoteDto;
use App\Domain\AlphaVantage\Entity\GlobalQuoteEntity;

final class GlobalQuoteEntityMapper
{
    public static function fromDto(
        GlobalQuoteDto $globalQuoteDTO,
    ): GlobalQuoteEntity {
        $decoded = json_decode($globalQuoteDTO->getRawResponse(), true);

        if (!is_array($decoded)) {
            throw new \RuntimeException('Invalid JSON in raw response');
        }

        $rawResponse = $decoded;

        return new GlobalQuoteEntity(
            $globalQuoteDTO->getSymbol()->value(),
            $globalQuoteDTO->getOpen(),
            $globalQuoteDTO->getHigh(),
            $globalQuoteDTO->getLow(),
            $globalQuoteDTO->getPrice(),
            $globalQuoteDTO->getVolume(),
            $globalQuoteDTO->getLatestTradingDay(),
            $globalQuoteDTO->getPreviousClose(),
            $globalQuoteDTO->getChange(),
            $globalQuoteDTO->getChangePercent(),
            $rawResponse,
        );
    }
}
