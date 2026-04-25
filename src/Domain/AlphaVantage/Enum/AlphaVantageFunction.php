<?php

declare(strict_types=1);

namespace App\Domain\AlphaVantage\Enum;

enum AlphaVantageFunction: string
{
    case GLOBAL_QUOTE = 'GLOBAL_QUOTE';
}
