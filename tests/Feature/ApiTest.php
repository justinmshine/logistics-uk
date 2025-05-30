<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TasksModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase; // Ensure a clean database for each test

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');
    }

    /**
     * Test to view all the tasks.
     */
    public function test_view_all_tasks(): void
    {
        $response = $this->get('/api/tasks');
        $response->assertStatus(200);
    }

    /**
     * Test to view a specific task.
     */
    public function test_view_a_specific_task(): void
    {
        $response = $this->get("/api/tasks/2");
        $response->assertStatus(200);
    }

    /**
     * Test user can register for an api key. 
     */
    public function test_users_can_register_for_an_api_key()
    {
        // Arrange: Create a user and set up the test environment
        $user = User::factory()->create();

        // Act: Sign in, log out, and assert the result
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',  // Assumes a default password for the user
        ]);
        $response->assertOk();
    }

    /**
     * Test user can login and logout
     */
    public function test_users_can_login_and_logout()
    {
        // Arrange: Create a user and set up the test environment
        $user = User::factory()->create();

        // Act: Sign in, log out, and assert the result
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',  // Assumes a default password for the user
        ]);
        $response->assertOk();
        $token = $response->json('token');

        // Set the token in the Authorization header for subsequent requests
        $this->withHeaders(['Authorization' => "Bearer {$token}"])->postJson('/api/logout');
        $this->assertGuest();
    }

    /**
     * Test api insert endpoint
     */
    public function test_authenticated_user_can_access_protected_insert_route()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',  // Assumes a default password for the user
        ]);
        $response->assertOk();
        $token = $response->json('token');

        $payload = ['title' => 'New Task Title', 'description' => 'New Task Description'];

        $this->withHeaders(['Authorization' => "Bearer {$token}"])->postJson("/api/tasks", $payload);
    }
    
    /**
     * Test api update endpoint
     */
    public function test_authenticated_user_can_access_protected_update_task()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',  // Assumes a default password for the user
        ]);
        $response->assertOk();
        $token = $response->json('token');

        $payload = ['title' => 'Updated Task Title updated', 'description' => 'Updated Task Description updated'];

        $this->withHeaders(['Authorization' => "Bearer {$token}"])->putJson("/api/tasks/3", $payload);
    }
    
    /**
     * Test api delete endpoint
     */
    public function test_authenticated_user_can_access_protected_delete_task()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',  // Assumes a default password for the user
        ]);
        $response->assertOk();
        $token = $response->json('token');

        $this->withHeaders(['Authorization' => "Bearer {$token}"])->deleteJson("/api/tasks/3");
    }
}
