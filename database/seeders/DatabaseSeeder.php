<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'password' => 'password',
            'level' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User2',
            'email' => 'user2@gmail.com',
            'password' => 'password',
            'level' => 2
        ]);

    }
}