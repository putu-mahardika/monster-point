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
            ->givePermissionTo(Permission::where('name', 'not like', 'merchants%')
                                ->pluck('id')
                                ->toArray());


        // ====================>>> Seeding Permission Only <<<====================
        // $roleAdmin = Role::findByName('super admin');
        // $roleAdmin->givePermissionTo(Permission::all());
        // $roleAdmin->givePermissionTo('billings access');

        // $roleMerchant = Role::findByName('merchant');
        // $roleMerchant->givePermissionTo('billings access');
        // $roleMerchant->givePermissionTo(Permission::where('name', 'not like', 'merchants%')
        //                                     ->pluck('id')
        //                                     ->toArray());
    }
}
