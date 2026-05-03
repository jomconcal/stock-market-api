<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Mapper\GlobalQuote;

use App\Domain\FinnHub\DTO\QuoteDto;
use App\Domain\FinnHub\Entity\GlobalQuoteEntity;

final class GlobalQuoteEntityMapper
{
    public static function fromDto(
        QuoteDto $globalQuoteDTO,
    ): GlobalQuoteEntity {
        return new GlobalQuoteEntity(
            $globalQuoteDTO->getSymbol(),
            $globalQuoteDTO->getOpen(),
            $globalQuoteDTO->getHigh(),
            $globalQuoteDTO->getLow(),
            $globalQuoteDTO->getCurrentPrice(),
            $globalQuoteDTO->getVolume(),
            $globalQuoteDTO->getLatestTradingDay(),
            $globalQuoteDTO->getPreviousClose(),
            $globalQuoteDTO->getChange(),
            $globalQuoteDTO->getChangePercent()
        );
    }
}
