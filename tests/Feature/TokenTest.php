<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // public function test_user_api_with_bearer_token()
    // {
    //     // Create users
    //     $admin = User::factory()->create(['role' => 'admin']);
    //     $user = User::factory()->create(['role' => 'user']);

    //     // Create Bearer token for admin
    //     $token = $admin->createToken('TestToken')->plainTextToken;

    //     // 1️⃣ Success: GET /profile
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->getJson('/api/profile');

    //     $response->assertStatus(200)
    //              ->assertJsonPath('data.id', $admin->id);

    //     // 2️⃣ Unauthorized: no token
    //     $response = $this->getJson('/api/profile');
    //     $response->assertStatus(401);

    //     // 3️⃣ Forbidden: user cannot access admin route
    //     $userToken = $user->createToken('UserToken')->plainTextToken;
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $userToken,
    //     ])->getJson('/api/admin-only');

    //     $response->assertStatus(403);

    //     // 4️⃣ Validation error: POST /users with missing fields
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->postJson('/api/users', []); // empty payload

    //     $response->assertStatus(422)
    //              ->assertJsonValidationErrors(['name', 'email', 'password']);

    //     // 5️⃣ Create a new user successfully
    //     $payload = [
    //         'name' => 'Sid Ali',
    //         'email' => 'sid@example.com',
    //         'password' => 'password',
    //     ];

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->postJson('/api/users', $payload);

    //     $response->assertStatus(201)
    //              ->assertJsonPath('data.name', 'Sid Ali');

    //     $this->assertDatabaseHas('users', [
    //         'email' => 'sid@example.com'
    //     ]);

    //     // 6️⃣ Delete user: 204 No Content
    //     $createdUserId = $response->json('data.id');
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->deleteJson("/api/users/{$createdUserId}");

    //     $response->assertStatus(204);
    //     $this->assertDatabaseMissing('users', ['id' => $createdUserId]);

    //     // 7️⃣ Not found: GET missing user
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->getJson("/api/users/999999");

    //     $response->assertStatus(404);
    // }
}