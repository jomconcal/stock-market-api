<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Enum;

enum FinnHubProvider: string
{
    case CACHE = 'Cache';
    case FINN_HUB = 'FinnHub';
}
