<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Super_Admin::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$yrY3.syuCkjyoQPbTjfDwePRLia28NsZCxSq8.nIO4emBm24/gUXe', // password
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('super_admin');
    }
}
