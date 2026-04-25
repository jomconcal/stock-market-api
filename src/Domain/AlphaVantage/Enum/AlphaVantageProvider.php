<?php

declare(strict_types=1);

namespace App\Domain\AlphaVantage\Enum;

enum AlphaVantageProvider: string
{
    case CACHE = 'Cache';
    case ALPHA_VANTAGE = 'Alpha Vantage';
}
