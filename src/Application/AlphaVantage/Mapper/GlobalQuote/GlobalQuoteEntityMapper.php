<?php

namespace App\Application\AlphaVantage\Mapper\GlobalQuote;

use App\Domain\AlphaVantage\DTO\GlobalQuoteDto;
use App\Domain\AlphaVantage\Entity\GlobalQuoteEntity;

final class GlobalQuoteEntityMapper
{
    public static function fromDto(
        GlobalQuoteDto $globalQuoteDTO,
    ): GlobalQuoteEntity {
        return new GlobalQuoteEntity(
            $globalQuoteDTO->getSymbol(),
            $globalQuoteDTO->getOpen(),
            $globalQuoteDTO->getHigh(),
            $globalQuoteDTO->getLow(),
            $globalQuoteDTO->getPrice(),
            $globalQuoteDTO->getVolume(),
            $globalQuoteDTO->getLatestTradingDay(),
            $globalQuoteDTO->getPreviousClose(),
            $globalQuoteDTO->getChange(),
            $globalQuoteDTO->getChangePercent()
        );
    }
}
