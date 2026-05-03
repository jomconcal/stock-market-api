<?php

declare(strict_types=1);

namespace App\Domain\FinnHub\Exception;

use App\Domain\StatusCode\HTTP_CODE;

class FinnHubConnectionException extends \Exception
{
    public static function create(
        string $message,
        ?\Throwable $previous = null): FinnHubConnectionException
    {
        return new self($message, HTTP_CODE::CONNECTION_ERROR, $previous);
    }
}
