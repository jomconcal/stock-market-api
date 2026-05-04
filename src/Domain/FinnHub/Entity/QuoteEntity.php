<?php

namespace App\Domain\FinnHub\Entity;

use App\Infrastructure\FinnHub\Persistence\QuoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
#[ORM\Table(name: 'global_quote')]
#[ORM\UniqueConstraint(
    name: 'uniq_symbol_last_update',
    columns: ['symbol', 'last_update']
)]
class QuoteEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeInterface $fetchedAt;

    public function __construct(
        #[ORM\Column(length: 10)]
        private string $symbol,

        #[ORM\Column(type: Types::FLOAT)]
        private float $currentPrice,   // c

        #[ORM\Column(type: Types::FLOAT)]
        private float $priceChange,          // d

        #[ORM\Column(type: Types::FLOAT)]
        private float $changePercent,   // dp

        #[ORM\Column(type: Types::FLOAT)]
        private float $high,            // h

        #[ORM\Column(type: Types::FLOAT)]
        private float $low,             // l

        #[ORM\Column(type: Types::FLOAT)]
        private float $open,            // o

        #[ORM\Column(type: Types::FLOAT)]
        private float $previousClose,   // pc

        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private \DateTimeImmutable $lastUpdate, // t
    ) {
        $this->fetchedAt = new \DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    public function getPriceChange(): float
    {
        return $this->priceChange;
    }

    public function getChangePercent(): float
    {
        return $this->changePercent;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getPreviousClose(): float
    {
        return $this->previousClose;
    }

    public function getLastUpdate(): \DateTimeImmutable
    {
        return $this->lastUpdate;
    }

    public function getFetchedAt(): \DateTimeInterface
    {
        return $this->fetchedAt;
    }

    public function setFetchedAt(\DateTimeInterface $fetchedAt): void
    {
        $this->fetchedAt = $fetchedAt;
    }
}
