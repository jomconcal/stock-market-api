<?php

declare(strict_types=1);

namespace App\Domain\AppUser;

enum UserRol: string
{
    case VISITOR = 'VISITOR';
    case USER = 'USER';
    case ADMIN = 'ADMIN';
}
