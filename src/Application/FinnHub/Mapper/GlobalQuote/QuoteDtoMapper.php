<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Mapper\GlobalQuote;

use App\Domain\FinnHub\DTO\QuoteDto;
use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\VO\Ticker;

final class QuoteDtoMapper
{
    public static function fromEntity(
        QuoteEntity $globalQuoteEntity,
    ): QuoteDto {
        $symbol = Ticker::create($globalQuoteEntity->getSymbol());
        $currenPrice = $globalQuoteEntity->getCurrentPrice();
        $priceChange = $globalQuoteEntity->getPriceChange();
        $changePercent = $globalQuoteEntity->getChangePercent();
        $open = $globalQuoteEntity->getOpen();
        $high = $globalQuoteEntity->getHigh();
        $low = $globalQuoteEntity->getLow();
        $previousClose = $globalQuoteEntity->getPreviousClose();
        $lastUpdate = $globalQuoteEntity->getLastUpdate();

        return QuoteDto::create(
            symbol: $symbol,
            currentPrice: $currenPrice,
            priceChange: $priceChange,
            changePercent: $changePercent,
            high: $high,
            low: $low,
            open: $open,
            previousClose: $previousClose,
            lastUpdate: $lastUpdate,
        );
    }
}
