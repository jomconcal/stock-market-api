<?php

namespace App\Application\AlphaVantage\Response;

use App\Domain\AlphaVantage\DTO\GlobalQuoteDto;

readonly class GlobalQuoteResponse
{
    private const string CACHE = 'CACHE';
    public const string SUCCESS = 'SUCCESS';
    public const string ERROR = 'ERROR';
    public const string PROVIDER = 'AlphaVantage';

    private function __construct(
        private string $status,
        private ?GlobalQuoteDto $globalQuoteDto,
        private ?string $provider,
        private ?string $message,
    ) {
    }

    public static function createFromProvider(
        GlobalQuoteDto $globalQuoteDto): self
    {
        return new self(
            self::SUCCESS,
            $globalQuoteDto,
            self::PROVIDER,
            null
        );
    }

    public static function createFromCache(GlobalQuoteDto $globalQuoteDto): self
    {
        return new self(
            self::SUCCESS,
            $globalQuoteDto,
            self::CACHE,
            null
        );
    }

    public static function createWithError(string $message): self
    {
        return new self(
            self::ERROR,
            null,
            null,
            $message
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function getSuccess(): array
    {
        return [
            'status' => $this->status,
            'globalQuote' => $this->globalQuoteDto?->toArray(),
            'provider' => $this->provider,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function getError(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }

    public function isError(): bool
    {
        return self::ERROR === $this->status;
    }
}
