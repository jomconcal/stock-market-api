<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Exception;

class FinnHubConnectionException extends \Exception
{
    public static function create(
        string $message,
        int $code,
        ?\Throwable $previous = null): FinnHubConnectionException
    {
        return new self($message, $code, $previous);
    }
}
