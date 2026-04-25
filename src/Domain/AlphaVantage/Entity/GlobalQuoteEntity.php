<?php

namespace App\Domain\AlphaVantage\Entity;

use App\Infrastructure\AlphaVantage\Persistence\GlobalQuoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: GlobalQuoteRepository::class)]
#[ORM\Table(name: 'global_quote')]
#[ORM\UniqueConstraint(
    name: 'uniq_symbol_trading_day',
    columns: ['symbol', 'latest_trading_day']
)]
class GlobalQuoteEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    public function __construct(
        #[ORM\Column(length: 10)]
        private string $symbol,

        #[ORM\Column(type: Types::FLOAT)]
        private float $open,

        #[ORM\Column(type: Types::FLOAT)]
        private float $high,

        #[ORM\Column(type: Types::FLOAT)]
        private float $low,

        #[ORM\Column(type: Types::FLOAT)]
        private float $price,

        #[ORM\Column(type: Types::INTEGER)]
        private int $volume,

        #[ORM\Column(length: 20)]
        private string $latestTradingDay,

        #[ORM\Column(type: Types::FLOAT)]
        private float $previousClose,

        #[ORM\Column(type: Types::FLOAT)]
        private float $priceChange,

        #[ORM\Column(length: 10)]
        private string $changePercent,

        #[ORM\Column(type: Types::DATETIME_MUTABLE)]
        private \DateTimeInterface $fetchedAt = new \DateTime(),
    ) {
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    // Getters
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function getLatestTradingDay(): string
    {
        return $this->latestTradingDay;
    }

    public function getPreviousClose(): float
    {
        return $this->previousClose;
    }

    public function getPriceChange(): float
    {
        return $this->priceChange;
    }

    public function getChangePercent(): string
    {
        return $this->changePercent;
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
