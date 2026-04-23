<?php

namespace App\Infrastructure\AlphaVantage\Factory;

use App\Domain\AlphaVantage\Entity\AlphaVantageLog;
use App\Domain\AlphaVantage\Enum\AlphaVantageFunction;
use App\Domain\AlphaVantage\Enum\AlphaVantageProvider;
use App\Domain\AlphaVantage\Enum\AlphaVantageStatus;
use App\Domain\AlphaVantage\VO\Symbol;

class AlphaVantageLogFactory
{
    public static function fromCache(
        Symbol $symbol,
        AlphaVantageFunction $function,
        array $rawResponse,
    ): AlphaVantageLog {
        return new AlphaVantageLog(
            AlphaVantageStatus::SUCCESS,
            $symbol->value(),
            $function,
            AlphaVantageProvider::CACHE,
            null,
            $rawResponse,
        );
    }

    public static function fromProvider(
        Symbol $symbol,
        AlphaVantageFunction $function,
        array $rawResponse,
    ): AlphaVantageLog {
        return new AlphaVantageLog(
            AlphaVantageStatus::SUCCESS,
            $symbol->value(),
            $function,
            AlphaVantageProvider::ALPHA_VANTAGE,
            null,
            $rawResponse,
        );
    }

    public static function fromError(
        string $symbol,
        AlphaVantageFunction $function,
        string $message,
        array $rawResponse,
    ): AlphaVantageLog {
        return new AlphaVantageLog(
            AlphaVantageStatus::ERROR,
            $symbol,
            $function,
            AlphaVantageProvider::ALPHA_VANTAGE,
            $message,
            $rawResponse,
        );
    }
}
