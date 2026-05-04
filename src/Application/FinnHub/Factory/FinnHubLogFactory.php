<?php

declare(strict_types=1);

namespace App\Application\FinnHub\Factory;

use App\Domain\FinnHub\Entity\FinnHubLog;
use App\Domain\FinnHub\Enum\FinnHubFunction;
use App\Domain\FinnHub\Enum\FinnHubProvider;
use App\Domain\FinnHub\Enum\FinnHubStatus;
use App\Domain\FinnHub\VO\Ticker;

final class FinnHubLogFactory
{
    /**
     * @param array<array-key, mixed> $rawResponse
     */
    public static function fromCache(
        Ticker $ticker,
        FinnHubFunction $function,
        array $rawResponse,
    ): FinnHubLog {
        return new FinnHubLog(
            FinnHubStatus::SUCCESS,
            $ticker->getSymbol(),
            $function,
            FinnHubProvider::CACHE,
            null,
            $rawResponse,
        );
    }

    /**
     * @param array<array-key, mixed> $rawResponse
     */
    public static function fromProvider(
        Ticker $ticker,
        FinnHubFunction $function,
        array $rawResponse,
        bool $replaced = false,
    ): FinnHubLog {
        $status = $replaced ? FinnHubStatus::REPLACED : FinnHubStatus::SUCCESS;

        return new FinnHubLog(
            $status,
            $ticker->getSymbol(),
            $function,
            FinnHubProvider::FINN_HUB,
            null,
            $rawResponse,
        );
    }

    /**
     * @param array<array-key, mixed> $rawResponse
     */
    public static function fromError(
        string $symbol,
        FinnHubFunction $function,
        string $message,
        array $rawResponse,
    ): FinnHubLog {
        return new FinnHubLog(
            FinnHubStatus::ERROR,
            $symbol,
            $function,
            FinnHubProvider::FINN_HUB,
            $message,
            $rawResponse,
        );
    }
}
