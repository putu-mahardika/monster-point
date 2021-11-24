<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'merchant'])
            ->givePermissionTo(function () {
                return Permission::where('name', 'not like', 'merchants%')
                                 ->pluck('name')
                                 ->toArray();
            });

    }
}
