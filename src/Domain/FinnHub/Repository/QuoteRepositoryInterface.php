<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Repository;

use App\Domain\FinnHub\Entity\QuoteEntity;

interface QuoteRepositoryInterface
{
    public function save(QuoteEntity $entity): void;

    public function findBySymbolAndLastUpdate(
        string $symbol,
        \DateTimeImmutable $lastUpdate): ?QuoteEntity;

    public function findWithinLast15Minutes(string $symbol): ?QuoteEntity;
}
