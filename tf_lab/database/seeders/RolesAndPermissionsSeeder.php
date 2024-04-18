<?php

namespace Database\Seeders;

use App\Models\user\UserRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        Role::create(['name' => UserRoles::ROLE_ADMIN]);
        Role::create(['name' => UserRoles::ROLE_MODERATOR]);
        Role::create(['name' => UserRoles::ROLE_USER]);

    }
}
