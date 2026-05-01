<?php

declare(strict_types=1);

namespace App\Domain\StatusCode;

class HTTP_CODE
{
    public const int OK = 200;
    public const int NOT_FOUND = 404;
    public const int INTERNAL_SERVER_ERROR = 500;
    public const int BAD_REQUEST = 400;
    public const int UNAUTHORIZED = 401;
    public const int FORBIDDEN = 403;
    public const int TOO_MANY_REQUESTS = 429;

    public const int CONNECTION_ERROR = 503;
}
