<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Enum;

enum FinnHubProvider: string
{
    case CACHE = 'CACHE';
    case FINN_HUB = 'FINN_HUB';
}
