<?php

declare(strict_types=1);

namespace App\Domain\AlphaVantage\Enum;

enum AlphaVantageStatus: string
{
    case SUCCESS = 'SUCCESS';
    case ERROR = 'ERROR';
    case WARNING = 'WARNING';
    case REPLACED = 'REPLACED';
}
