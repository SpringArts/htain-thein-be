<?php

namespace Tests\Feature\User;

use App\Enums\UserRoleType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private function auth_user_create()
    {
        $user = User::factory()->create([
            'role' => UserRoleType::SUPER_ADMIN,
        ]);
        $this->actingAs($user);

        return $user;
    }

    public function test_index()
    {
        $this->auth_user_create();
        User::factory()->count(3)->create();
        $response = $this->get('/api/app/users');

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }

    public function test_store()
    {

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$/wQTKHDVTKcZXxqvgXHR5.yOr6vjBkHoErWrI0vhnHCs6rhF8LTRW',
            'remember_token' => Str::random(10),
            'accountStatus' => 'ACTIVE',
            'role' => UserRoleType::ADMIN,
        ];

        $this->auth_user_create();
        $response = $this->post('/api/app/users', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_show()
    {
        $this->auth_user_create();

        $user = User::factory()->create();

        $response = $this->get("/api/app/users/{$user->id}");
        $createdAt = $user->created_at->format('Y-d-M');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'accountStatus' => $user->account_status,
                    'createdAt' => $createdAt,
                ],
            ]);
    }

    public function test_update()
    {
        $this->auth_user_create();
        $user = User::factory()->create();
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'Admin',
            'accountStatus' => 'ACTIVE',
        ];

        $response = $this->put("/api/app/users/{$user->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }

    public function testDestroy()
    {
        $this->auth_user_create();

        $user = User::factory()->create();
        $response = $this->delete("/api/app/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully Deleted',
                'data' => null,
            ]);
    }
}
