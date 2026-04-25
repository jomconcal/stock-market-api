<?php

declare(strict_types=1);

namespace App\Application\AlphaVantage\Mapper\GlobalQuote;

use App\Domain\AlphaVantage\DTO\GlobalQuoteDto;
use App\Domain\AlphaVantage\Entity\GlobalQuoteEntity;

final class GlobalQuoteDtoMapper
{
    public static function fromEntity(
        GlobalQuoteEntity $globalQuoteEntity,
    ): GlobalQuoteDto {
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

        return GlobalQuoteDto::create(
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
