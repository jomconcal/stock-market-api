<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Mapper\GlobalQuote;

use App\Domain\FinnHub\DTO\QuoteDto;
use App\Domain\FinnHub\Entity\QuoteEntity;

final class QuoteEntityMapper
{
    public static function fromDto(
        QuoteDto $quoteDto,
    ): QuoteEntity {
        return new QuoteEntity(
            $quoteDto->getTicker()->getSymbol(),
            $quoteDto->getCurrentPrice(),
            $quoteDto->getPriceChange(),
            $quoteDto->getChangePercent(),
            $quoteDto->getHigh(),
            $quoteDto->getLow(),
            $quoteDto->getOpen(),
            $quoteDto->getPreviousClose(),
            $quoteDto->getLastUpdate(),
        );
    }
}
