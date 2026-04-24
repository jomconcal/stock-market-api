<?php

namespace App\Domain\AlphaVantage\Entity;

use App\Domain\AlphaVantage\Enum\AlphaVantageFunction;
use App\Domain\AlphaVantage\Enum\AlphaVantageProvider;
use App\Domain\AlphaVantage\Enum\AlphaVantageStatus;
use App\Domain\AlphaVantage\Repository\AlphaVantageLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AlphaVantageLogRepository::class)]
class AlphaVantageLog
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue]
    private ?Uuid $id = null;

    public function __construct(
        #[ORM\Column(enumType: AlphaVantageStatus::class)]
        private AlphaVantageStatus $status,

        #[ORM\Column(length: 10)]
        private string $symbol,

        #[ORM\Column(enumType: AlphaVantageFunction::class)]
        private AlphaVantageFunction $alphaVantageFunction,

        #[ORM\Column(enumType: AlphaVantageProvider::class)]
        private AlphaVantageProvider $provider,

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $message,
        /**
         * @var array<array-key, mixed>
         */
        #[ORM\Column(type: Types::JSON)]
        private array $rawResponse,

        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private \DateTimeInterface $fetchedAt = new \DateTimeImmutable(),
    ) {
    }

    public function getStatus(): AlphaVantageStatus
    {
        return $this->status;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getAlphaVantageFunction(): AlphaVantageFunction
    {
        return $this->alphaVantageFunction;
    }

    public function getProvider(): AlphaVantageProvider
    {
        return $this->provider;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return array<array-key,mixed>
     */
    public function getRawResponse(): array
    {
        return $this->rawResponse;
    }

    public function getFetchedAt(): \DateTimeInterface
    {
        return $this->fetchedAt;
    }
}
