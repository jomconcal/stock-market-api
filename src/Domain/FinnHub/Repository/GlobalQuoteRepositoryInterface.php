<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Repository;

use App\Domain\FinnHub\Entity\GlobalQuoteEntity;

interface GlobalQuoteRepositoryInterface
{
    public function save(GlobalQuoteEntity $entity): void;

    public function findByFetchedTodayAndSymbol(string $symbol): ?GlobalQuoteEntity;

    public function replace(GlobalQuoteEntity $globalQuoteEntity): void;

    public function getBySymbolAndLatestTradingDay(
        string $symbol,
        string $latestTradingDay): ?GlobalQuoteEntity;
}
