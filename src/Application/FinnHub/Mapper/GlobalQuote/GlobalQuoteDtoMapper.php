<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Mapper\GlobalQuote;

use App\Domain\FinnHub\DTO\QuoteDto;
use App\Domain\FinnHub\Entity\GlobalQuoteEntity;

final class GlobalQuoteDtoMapper
{
    public static function fromEntity(
        GlobalQuoteEntity $globalQuoteEntity,
    ): QuoteDto {
        $symbol = $globalQuoteEntity->getSymbol();
        $open = $globalQuoteEntity->getOpen();
        $high = $globalQuoteEntity->getHigh();
        $low = $globalQuoteEntity->getLow();
        $price = $globalQuoteEntity->getPrice();
        $volume = $globalQuoteEntity->getVolume();
        $latestTradingDay = $globalQuoteEntity->getLatestTradingDay();
        $previousClose = $globalQuoteEntity->getPreviousClose();
        $priceChange = $globalQuoteEntity->getPriceChange();
        $changePercent = $globalQuoteEntity->getChangePercent();

        return QuoteDto::create(
            $symbol,
            $open,
            $high,
            $low,
            $price,
            $volume,
            $latestTradingDay,
            $previousClose,
            $priceChange,
            $changePercent
        );
    }
}
