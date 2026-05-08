<?php

namespace App\Domain\FinnHub\Entity;

use App\Domain\FinnHub\Enum\FinnHubFunction;
use App\Domain\FinnHub\Enum\FinnHubProvider;
use App\Domain\FinnHub\Enum\FinnHubStatus;
use App\Infrastructure\FinnHub\Persistence\FinnHubLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FinnHubLogRepository::class)]
class FinnHubLog
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    public function __construct(
        #[ORM\Column(enumType: FinnHubStatus::class)]
        private FinnHubStatus $status,

        #[ORM\Column(length: 10)]
        private string $symbol,

        #[ORM\Column(enumType: FinnHubFunction::class)]
        private FinnHubFunction $finnHubFunction,

        #[ORM\Column(enumType: FinnHubProvider::class)]
        private FinnHubProvider $provider,

        /**
         * @var array<array-key, mixed>
         */
        #[ORM\Column(type: Types::JSON)]
        private array $response,

        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private \DateTimeInterface $fetchedAt = new \DateTimeImmutable(),
    ) {
    }

    public function getStatus(): FinnHubStatus
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

    public function getFinnHubFunction(): FinnHubFunction
    {
        return $this->finnHubFunction;
    }

    public function getProvider(): FinnHubProvider
    {
        return $this->provider;
    }

    /**
     * @return array<array-key,mixed>
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    public function getFetchedAt(): \DateTimeInterface
    {
        return $this->fetchedAt;
    }
}
