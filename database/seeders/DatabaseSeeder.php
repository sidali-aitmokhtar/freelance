<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'money'=>200,
            'password'=>'npc'
        ]);

        User::factory()->create([
            'money'=>50,
            'password'=>'npc'
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' =>'admin',
            'role' =>'admin'
        ]);

        User::factory()->create([
            'name' => 'ali',
            'email' => 'ali@example.com',
            'password' =>'ali',
            'role' =>'freelancer'
        ]);
        User::factory()->create([
            'name' => 'sid',
            'email' => 'sid@example.com',
            'password' =>'sid',
            'role' =>'freelancer'
        ]);
    }
}
