<?php

namespace App\Domain\AlphaVantage\Enum;

enum AlphaVantageStatus: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case WARNING = 'warning';
}
