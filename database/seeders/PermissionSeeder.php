<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard access']);
        Permission::create(['name' => 'dashboard chart 1 access']);
        Permission::create(['name' => 'dashboard chart 2 access']);
        Permission::create(['name' => 'dashboard chart 3 access']);

        Permission::create(['name' => 'merchants access']);
        Permission::create(['name' => 'merchants create']);
        Permission::create(['name' => 'merchants edit']);
        Permission::create(['name' => 'merchants delete']);

        Permission::create(['name' => 'members access']);
        Permission::create(['name' => 'members create']);
        Permission::create(['name' => 'members edit']);
        Permission::create(['name' => 'members delete']);

        Permission::create(['name' => 'events access']);
        Permission::create(['name' => 'events create']);
        Permission::create(['name' => 'events edit']);
        Permission::create(['name' => 'events delete']);

        Permission::create(['name' => 'profile access']);
        Permission::create(['name' => 'profile edit']);
    }
}
