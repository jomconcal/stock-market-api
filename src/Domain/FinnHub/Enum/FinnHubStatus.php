<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Enum;

enum FinnHubStatus: string
{
    case SUCCESS = 'SUCCESS';
    case ERROR = 'ERROR';
    case WARNING = 'WARNING';
    case REPLACED = 'REPLACED';
}
