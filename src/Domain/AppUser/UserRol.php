<?php

declare(strict_types=1);

namespace App\Domain\AppUser;

enum UserRol: string
{
    case ROLE_VISITOR = 'ROLE_VISITOR';
    case ROLE_USER = 'ROLE_USER';
    case ROLE_ADMIN = 'ROLE_ADMIN';
}
