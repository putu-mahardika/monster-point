<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@monsterpoint.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'isShowPopupVerify' => true,
        ])
        ->assignRole('super admin');

        // info('Name: Super Admin');
        // info('Email: superadmin@monsterpoint.com');
        // info('Password: password');
    }
}
