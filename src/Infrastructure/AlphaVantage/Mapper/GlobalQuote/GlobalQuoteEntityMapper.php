<?php

namespace App\Infrastructure\AlphaVantage\Mapper\GlobalQuote;

use App\Application\AlphaVantage\DTO\GlobalQuoteDto;
use App\Domain\AlphaVantage\Entity\GlobalQuoteEntity;

class GlobalQuoteEntityMapper
{
    public static function fromDto(
        GlobalQuoteDto $globalQuoteDTO,
    ): GlobalQuoteEntity {
        $rawResponse = json_decode($globalQuoteDTO->getRawResponse(), true);

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
