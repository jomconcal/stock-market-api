<?php

namespace App\Infrastructure\FinnHub\Persistence;

use App\Domain\FinnHub\Entity\QuoteEntity;
use App\Domain\FinnHub\Repository\QuoteRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuoteEntity>
 */
class QuoteRepository extends ServiceEntityRepository implements QuoteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuoteEntity::class);
    }

    #[\Override]
    public function save(QuoteEntity $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    #[\Override]
    public function findBySymbolAndLastUpdate(string $symbol, \DateTimeImmutable $lastUpdate): ?QuoteEntity
    {
        return $this->findOneBy([
            'symbol' => $symbol,
            'lastUpdate' => $lastUpdate,
        ]);
    }

    #[\Override]
    public function findWithinLast15Minutes(string $symbol): ?QuoteEntity
    {
        $threshold = new \DateTimeImmutable('-15 minutes');

        $qb = $this->createQueryBuilder('q');
        $qb->where('q.symbol = :symbol')
            ->andWhere('q.lastUpdate >= :threshold')
            ->setParameter('symbol', $symbol)
            ->setParameter('threshold', $threshold)
            ->orderBy('q.lastUpdate', 'DESC')
            ->setMaxResults(1);
        $query = $qb->getQuery();
        /** @var QuoteEntity|null $quoteEntity */
        $quoteEntity = $query->getOneOrNullResult();

        return $quoteEntity;
    }
}
