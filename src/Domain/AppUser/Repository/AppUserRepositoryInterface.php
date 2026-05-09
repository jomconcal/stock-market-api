<?php

declare(strict_types=1);

namespace App\Domain\AppUser\Repository;

use App\Domain\AppUser\Entity\AppUser;

interface AppUserRepositoryInterface
{
    public function findByEmail(string $email): ?AppUser;

    public function save(AppUser $appUser): void;
}
