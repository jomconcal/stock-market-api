<?php

declare(strict_types=1);

namespace App\Infrastructure\AppUser\Persistence;

use App\Domain\AppUser\Entity\AppUser;
use App\Domain\AppUser\Repository\AppUserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppUser>
 */
class AppUserRepository extends ServiceEntityRepository implements AppUserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppUser::class);
    }

    #[\Override]
    public function save(AppUser $appUser): void
    {
        $this->getEntityManager()->persist($appUser);
        $this->getEntityManager()->flush();
    }

    #[\Override]
    public function findByEmail(string $email): ?AppUser
    {
        return $this->findOneBy(['email' => $email]);
    }
}
