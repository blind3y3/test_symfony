<?php

declare(strict_types=1);

namespace App\DataKeeper;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
