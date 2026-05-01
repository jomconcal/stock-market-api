<?php

declare(strict_types=1);

namespace App\Domain\AlphaVantage\Exception;

use App\Domain\StatusCode\HTTP_CODE;

class AlphaVantageLimitException extends \Exception
{
    public static function create(): AlphaVantageLimitException
    {
        return new self('We have detected your API key as *** and our standard API rate limit is 25 requests per day.', HTTP_CODE::TOO_MANY_REQUESTS);
    }
}
