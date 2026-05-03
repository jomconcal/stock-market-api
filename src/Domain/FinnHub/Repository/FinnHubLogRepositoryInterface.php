<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Repository;

use App\Domain\FinnHub\Entity\FinnHubLog;

interface FinnHubLogRepositoryInterface
{
    public function save(FinnHubLog $finnHubLog): void;
}
