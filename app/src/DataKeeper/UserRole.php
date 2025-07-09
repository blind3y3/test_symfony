<?php

declare(strict_types=1);

namespace App\DataKeeper;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
}
