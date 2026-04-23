<?php

namespace App\Infrastructure\AlphaVantage\Mapper\GlobalQuote;

use App\Application\AlphaVantage\DTO\GlobalQuoteDto;
use App\Domain\AlphaVantage\Entity\GlobalQuoteEntity;
use App\Domain\AlphaVantage\VO\Symbol;

class GlobalQuoteDtoMapper
{
    public static function fromEntity(
        GlobalQuoteEntity $globalQuoteEntity,
    ): GlobalQuoteDto {
        $rawResponse = json_encode($globalQuoteEntity->getRawResponse(), JSON_THROW_ON_ERROR);
        $symbol = Symbol::create($globalQuoteEntity->getSymbol());
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
            $changePercent,
            $rawResponse
        );
    }
}
