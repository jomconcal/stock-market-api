<?php

namespace App\Infrastructure\AlphaVantage\Factory;

use App\Application\AlphaVantage\DTO\GlobalQuoteDTO;
use App\Domain\AlphaVantage\Entity\GlobalQuoteEntity;

class GlobalQuoteFactory
{

    public static function createGlobalQuoteEntityFromDto(
        GlobalQuoteDTO $globalQuoteDTO
    ) : GlobalQuoteEntity{
        $rawResponse = json_decode($globalQuoteDTO->getRawResponse(), true);
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
            $globalQuoteDTO->getChangePercent(),
            $rawResponse,
        );
    }

    public static function createGlobalQuoteDtoFromEntity(
        GlobalQuoteEntity $globalQuoteEntity
    ) : GlobalQuoteDTO{
        $rawResponse = json_encode($globalQuoteEntity->getRawResponse(), true);
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

        return GlobalQuoteDTO::create(
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
            $rawResponse,
            'Cache'
        );
    }
}
