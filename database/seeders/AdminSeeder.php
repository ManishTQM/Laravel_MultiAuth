<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$yrY3.syuCkjyoQPbTjfDwePRLia28NsZCxSq8.nIO4emBm24/gUXe', // password
            // 'remember_token' => Str::random(10),
        ]);
        $user->assignRole(1);
    }
}
