<?php

namespace App\Application\FinnHub\Response;

use App\Domain\FinnHub\DTO\QuoteDto;
use App\Domain\StatusCode\HTTP_CODE;

readonly class QuoteResponse
{
    private const string CACHE = 'CACHE';
    private const string SUCCESS = 'SUCCESS';
    private const string ERROR = 'ERROR';
    private const string PROVIDER = 'FinnHub';
    private const string UPDATE = 'UPDATE';

    private function __construct(
        private string $status,
        private ?QuoteDto $globalQuoteDto,
        private ?string $provider,
        private ?string $message,
        private int $code,
    ) {
    }

    public static function createFromProvider(
        QuoteDto $globalQuoteDto): self
    {
        return new self(
            self::SUCCESS,
            $globalQuoteDto,
            self::PROVIDER,
            null,
            HTTP_CODE::OK
        );
    }

    public static function createFromCache(QuoteDto $globalQuoteDto): self
    {
        return new self(
            self::SUCCESS,
            $globalQuoteDto,
            self::CACHE,
            null,
            HTTP_CODE::OK
        );
    }

    public static function createWithError(\Throwable $error): self
    {
        $message = $error->getMessage();
        $code = (int) $error->getCode();

        return new self(
            self::ERROR,
            null,
            null,
            $message,
            $code
        );
    }

    public static function createFromUpdate(QuoteDto $fromEntity): self
    {
        return new self(
            self::UPDATE,
            $fromEntity,
            self::PROVIDER,
            null,
            HTTP_CODE::OK
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function getSuccess(): array
    {
        return [
            'code' => $this->code,
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
            'code' => $this->code,
            'status' => $this->status,
            'message' => $this->message,
        ];
    }

    public function isError(): bool
    {
        return self::ERROR === $this->status;
    }
}
