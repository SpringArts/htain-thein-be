<?php

namespace Tests\Feature\GeneralOutcome;

use App\Enums\UserRoleType;
use App\Models\GeneralOutcome;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneralOutcomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $this->auth_user_create();
        User::factory()->count(3)->create();
        GeneralOutcome::factory()->count(3)->create();
        $response = $this->get('/api/app/general-outcomes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta'
            ]);
    }

    public function test_store()
    {
        $authUser = $this->auth_user_create();
        $data = [
            'reporter_id' => $authUser->id,
            'description' => 'Content of the announcement',
            'amount' => 1000,
        ];


        $response = $this->post('/api/app/general-outcomes', $data);
        $response->assertStatus(201)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully Created',
                'data' => null
            ]);
    }

    public function test_show()
    {
        $authUser = $this->auth_user_create();

        $generalOutcome = GeneralOutcome::factory()->create(
            [
                'reporter_id' => $authUser->id,
            ]
        );

        $response = $this->get("/api/app/general-outcomes/{$generalOutcome->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_update()
    {
        $authUser = $this->auth_user_create();
        $data = [
            'reporter_id' => $authUser->id,
            'description' => 'Content of the description',
            'amount' => 3000,
        ];
        $generalOutcome = GeneralOutcome::factory()->create(
            [
                'reporter_id' => $authUser->id,
            ]
        );

        $response = $this->put("/api/app/general-outcomes/{$generalOutcome->id}", $data);
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

        $generalOutcome = GeneralOutcome::factory()->create(
            [
                'reporter_id' => $authUser->id,
            ]
        );
        $response = $this->delete("/api/app/general-outcomes/{$generalOutcome->id}");
        $response->assertStatus(200)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully Deleted',
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
