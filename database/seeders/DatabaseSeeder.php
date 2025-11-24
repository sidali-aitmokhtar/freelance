<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin=Role::create([
            'name'=>'admin'
        ]);
        $client=Role::create([
            'name'=>'client'
        ]);
        $freelancer=Role::create([
            'name'=>'freelancer'
        ]);


        Permission::firstOrCreate(['name'=>'users.view']);
        Permission::firstOrCreate(['name'=>'users.create']);
        Permission::firstOrCreate(['name'=>'users.update']);
        Permission::firstOrCreate(['name'=>'users.delete']);

        Permission::firstOrCreate(['name'=>'projects.view']);
        Permission::firstOrCreate(['name'=>'projects.create']);
        Permission::firstOrCreate(['name'=>'projects.update']);
        Permission::firstOrCreate(['name'=>'projects.delete']);
        
        Permission::firstOrCreate(['name'=>'bids.view']);
        Permission::firstOrCreate(['name'=>'bids.create']);
        Permission::firstOrCreate(['name'=>'bids.update']);
        Permission::firstOrCreate(['name'=>'bids.delete']);

        Permission::firstOrCreate(['name'=>'contracts.view']);
        Permission::firstOrCreate(['name'=>'contracts.create']);
        Permission::firstOrCreate(['name'=>'contracts.update']);
        Permission::firstOrCreate(['name'=>'contracts.delete']);




        $admin->syncPermissions([
            'users.view','users.create','users.update','users.delete',
            'projects.view','projects.create','projects.update','projects.delete',
            'bids.view','bids.create','bids.update','bids.delete',
            'contracts.view','contracts.create','contracts.update','contracts.delete'
        ]);
        $client->syncPermissions([
            'users.view','users.update','users.delete',
            'projects.view','projects.create','projects.update','projects.delete',
            'bids.view',
            'contracts.view','contracts.create','contracts.delete'
        ]);
        $freelancer->syncPermissions([
            'users.view','users.update','users.delete',
            'projects.view',
            'bids.view','bids.create','bids.update','bids.delete',
            'contracts.view','contracts.create','contracts.delete'
        ]);



        User::factory()->create([
            'money'=>200,
            'password'=>'npc'
        ])->assignRole($client);

        User::factory()->create([
            'money'=>50,
            'password'=>'npc'
        ])->assignRole($client);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' =>'admin'
        ])->assignRole($admin);

        User::factory()->create([
            'name' => 'ali',
            'email' => 'ali@example.com',
            'password' =>'ali'
        ])->assignRole($freelancer);
        User::factory()->create([
            'name' => 'sid',
            'email' => 'sid@example.com',
            'password' =>'sid'
        ])->assignRole($freelancer);

        
    }
}
