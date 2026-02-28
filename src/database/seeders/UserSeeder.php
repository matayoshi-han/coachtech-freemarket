<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 自分用（ID: 1）
        \App\Models\User::create([
            'name'     => '自分',
            'email'    => 'me@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 他の出品者（ID: 2〜4）
        for ($i = 1; $i <= 3; $i++) {
            \App\Models\User::create([
                'name'     => "出品者{$i}",
                'email'    => "test{$i}@example.com",
                'password' => bcrypt('password123'),
            ]);
        }
    }
}
