<?php

namespace App\Mapper;

use App\DTO\GlobalQuoteDTO;
use App\Entity\GlobalQuoteEntity;

class AlphaVantageMapper
{

    public static function mapGlobalQuote($array) : GlobalQuoteDTO{
        $quote = $array["Global Quote"];
        $symbol = $quote["01. symbol"];
        $open = (float) $quote["02. open"];
        $high = (float) $quote["03. high"];
        $low = (float) $quote["04. low"];
        $price = (float) $quote["05. price"];
        $volume = (int) $quote["06. volume"];
        $latestTradingDay = $quote["07. latest trading day"];
        $previousClose = (float) $quote["08. previous close"];
        $change = (float) $quote["09. change"];
        $changePercent = $quote["10. change percent"];
        $rawResponse = json_encode($array);

        return GlobalQuoteDTO::create(
            $symbol,
            $open,
            $high,
            $low,
            $price,
            $volume,
            $latestTradingDay,
            $previousClose,
            $change,
            $changePercent,
            $rawResponse,
            'AlphaVantage'
        );
    }

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

    public static function createGlobalQuoteDtoFromEntity(GlobalQuoteEntity $globalQuoteEntity) : GlobalQuoteDTO{
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
