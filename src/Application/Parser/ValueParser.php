<?php

declare(strict_types=1);

namespace App\Application\Parser;

class ValueParser
{
    public static function toString(mixed $value): string
    {
        if (null === $value) {
            throw new \InvalidArgumentException('Value cannot be null');
        }

        if (!is_scalar($value)) {
            throw new \InvalidArgumentException('Expected string, got '.gettype($value));
        }

        return (string) $value;
    }

    public static function toInt(mixed $value): int
    {
        if (null === $value) {
            throw new \InvalidArgumentException('Value cannot be null');
        }

        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Expected integer, got '.gettype($value));
        }

        return (int) $value;
    }

    public static function toFloat(mixed $value): float
    {
        if (null === $value) {
            throw new \InvalidArgumentException('Value cannot be null');
        }

        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Expected float, got '.gettype($value));
        }

        return (float) $value;
    }

    public static function toBool(mixed $value): bool
    {
        if (!is_scalar($value)) {
            throw new \InvalidArgumentException('Expected boolean, got '.gettype($value));
        }

        return (bool) $value;
    }
}
