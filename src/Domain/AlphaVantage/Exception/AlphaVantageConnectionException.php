<?php

declare(strict_types=1);

namespace App\Domain\AlphaVantage\Exception;

use App\Domain\StatusCode\HTTP_CODE;

class AlphaVantageConnectionException extends \Exception
{
    public static function create(
        string $message,
        ?\Throwable $previous = null): AlphaVantageConnectionException
    {
        return new self($message, HTTP_CODE::CONNECTION_ERROR, $previous);
    }
}
