<?php

namespace App\Application\AlphaVantage\Exception;

class AlphaVantageConnectionException extends \Exception
{
    public static function create(
        string $message,
        int $code,
        ?\Throwable $previous = null): AlphaVantageConnectionException
    {
        return new self($message, $code, $previous);
    }
}
