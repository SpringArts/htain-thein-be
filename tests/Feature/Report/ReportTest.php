<?php

namespace Tests\Feature\Report;

use App\Enums\UserRoleType;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $this->auth_user_create();
        User::factory()->count(3)->create();
        Report::factory()->count(3)->create();
        $response = $this->get('/api/app/reports');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta',
            ]);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        $data = [
            'amount' => 2000,
            'description' => 'This is a test report',
            'type' => 'INCOME',
            'confirm_status' => 1,
            'reporter_id' => $user->id,
            'verifier_id' => $user->id,
        ];

        $this->auth_user_create();

        $response = $this->post('/api/app/reports', $data);
        $response->assertStatus(201)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully created',
                'data' => null,
            ]);
    }

    public function test_show()
    {
        $authUser = $this->auth_user_create();
        $user = User::factory()->create([
            'role' => UserRoleType::SUPER_ADMIN,
        ]);
        $report = Report::factory()->create(
            [
                'reporter_id' => $user->id,
                'verifier_id' => $authUser->id,
            ]
        );

        $response = $this->get("/api/app/reports/{$report->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    private function auth_user_create()
    {
        $user = User::factory()->create([
            'role' => UserRoleType::SUPER_ADMIN,
            'account_status' => 'ACTIVE',
        ]);
        $this->actingAs($user);

        return $user;
    }

    public function test_update()
    {
        $authUser = $this->auth_user_create();
        $user = User::factory()->create();
        $data = [
            'amount' => 3000,
            'description' => 'This is a test report Update',
            'type' => 'INCOME',
            'confirm_status' => 1,
            'reporter_id' => $authUser->id,
            'verifier_id' => $user->id,
        ];
        $report = Report::factory()->create(
            [
                'reporter_id' => $authUser->id,
                'verifier_id' => $user->id,
            ]
        );

        $response = $this->put("/api/app/reports/{$report->id}", $data);
        $response->assertStatus(200)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully Updated',
                'data' => null,
            ]);
    }

    public function testDestroy()
    {
        $this->auth_user_create();

        $report = Report::factory()->create(
            [
                'reporter_id' => User::factory()->create()->id,
                'verifier_id' => User::factory()->create()->id,
            ]
        );
        $response = $this->delete("/api/app/reports/{$report->id}");
        $response->assertStatus(200)
            ->assertJson([
                'alertVisible' => 1,
                'msg' => 'Successfully deleted',
                'data' => null,
            ]);
    }
}
