<?php

namespace Tests\Feature\Announcements;

use App\Enums\UserRoleType;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $this->auth_user_create();
        User::factory()->count(3)->create();
        Announcement::factory()->count(3)->create();
        $response = $this->get('/api/app/announcements');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        $data = [
            'title' => 'Announcement Title',
            'slug' => "work",
            'content' => 'Content of the announcement',
            'isVisible' => 1,
            'priority' => 1,
            'userId' => $user->id,
        ];

        $this->auth_user_create();

        $response = $this->post('/api/app/announcements', $data);
        $response->assertStatus(201)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully created',
                'data' => null
            ]);
    }

    public function test_show()
    {
        $authUser = $this->auth_user_create();

        $announcement = Announcement::factory()->create(
            [
                'user_id' => $authUser->id,
            ]
        );

        $response = $this->get("/api/app/announcements/{$announcement->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_update()
    {
        $authUser = $this->auth_user_create();
        $user = User::factory()->create();
        $data = [
            'title' => 'Announcement Title',
            'slug' => "work",
            'content' => 'Content of the announcement',
            'isVisible' => 1,
            'priority' => 1,
            'userId' => $user->id,
        ];
        $announcement = Announcement::factory()->create(
            [
                'user_id' => $authUser->id,
            ]
        );

        $response = $this->put("/api/app/announcements/{$announcement->id}", $data);
        $response->assertStatus(200)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully Updated',
                'data' => null
            ]);
    }

    public function testDestroy()
    {
        $authUser = $this->auth_user_create();

        $announcement = Announcement::factory()->create(
            [
                'user_id' => $authUser->id,
            ]
        );
        $response = $this->delete("/api/app/announcements/{$announcement->id}");
        $response->assertStatus(200)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully deleted',
                'data' => null,
            ]);
    }

    private function auth_user_create()
    {
        $user = User::factory()->create([
            'role' => UserRoleType::SUPER_ADMIN,
            'account_status' => 'ACTIVE'
        ]);
        $this->actingAs($user);
        return $user;
    }
}
