<?php

namespace App\Models\user;

enum UserRoles
{
    const ROLE_USER = 'User';
    const ROLE_ADMIN = 'Admin';
    const ROLE_MODERATOR = 'Moderator';
}
