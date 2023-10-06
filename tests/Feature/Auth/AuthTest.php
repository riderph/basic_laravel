<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Config environment and data for testing
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        $this->truncateDataTables(['users']);
    }

    /**
     * Truncate data table
     * 
     * @return void
     */
    protected function tearDown(): void
    {
        $this->truncateDataTables(['users']);
    }

    /**
     * A basic test example.
     */
    public function test_register_successful_response(): void
    {
        $user = [
            "name" => "test123",
            "email" => "test@gmail.com",
            "password" => "password",
            "password_confirm" => "password",
        ];
        $response = $this->post('api/auth/register', $user);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data']);
    }

    public function test_register_fail_validation(): void
    {
        $user = [
            "name" => "test1",
            "password" => "password",
            "password_confirm" => "password",
        ];
        $response = $this->post('api/auth/register', $user);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['errors']);
    }

    public function test_login_failed_response(): void
    {
        $user = [
            "email" => "test@gmail.com",
            "password" => "password2",
        ];
        $response = $this->post('api/auth', $user);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['errors']);
    }

    public function test_login_successful_response(): void
    {
        $user = [
            "email" => "test@gmail.com",
            "password" => "password",
        ];
        $this->createUserForLogin($user);
        $response = $this->post('api/auth', $user);
        $response->assertStatus(Response::HTTP_OK);
    }

    private function createUserForLogin($user): void
    {
        $user = [
            "name" => $user['email'],
            "email" => $user['email'],
            "password" => $user['password'],
            "password_confirm" => $user['password'],
        ];
        $this->post('api/auth/register', $user);
    }
    
}
