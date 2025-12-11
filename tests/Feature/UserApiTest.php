<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }


    public function test_list_users(): void
    {
        User::factory(3)->create();
        $response = $this->getJson('api/v1/users');

        $response->assertStatus(200)
                 ->assertJsonCount(8,'data');
    }
    public function test_create_user():void
    {
        $admin=User::factory()->create();
        $admin->assignRole('admin');
        $token=$admin->createToken($admin->name)->plainTextToken;

        $value=[
            'name'=>'aitmokhtar',
            'email'=>'ait@gmail.com',
            'password'=>'password',
            'money'=>100.00,
            'role'=>'admin'
        ];
        $response=$this->withHeaders([
            'Authorization'=>'Bearer ' . $token,
        ])->postJson('api/v1/users',$value);
        $response->assertStatus(201)
                 ->assertJsonPath('data.name','aitmokhtar');

        $this->assertDatabaseHas('users',[
            'email'=>'ait@gmail.com'
        ]);
    }
}
