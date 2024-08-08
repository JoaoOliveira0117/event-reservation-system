<?php

namespace Tests\Feature;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private function getValidPaylod() {
        return [
            'email'=> 'userexample@gmail.com',
            'username' => 'user_name',
            'password'=> '@@#@!@#SECUREPASSWORD123!@!@!@',
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
    }
    /**
     * A basic feature test example.
     */
    public function test_user_can_register(): void
    {
        $payload = $this->getValidPaylod();
        
        $this->json('post', 'api/register', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'username',
                    'created_at',
                    'updated_at',
                ],
                'success',
            ]);
    }

    public function test_user_can_not_register_with_invalid_credentials(): void
    {
        $payload = [
            'email'=> 'invalid@email',
            'username' => '',
            'password'=> 'password',
        ];
        
        $this->json('post', 'api/register', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'data' => [
                    'email',
                    'username',
                    'password',
                ],
                'success',
            ]);
    }

    public function test_user_can_not_register_with_existing_email_and_username(): void
    {
        $payload = $this->getValidPaylod();
        
        $this->json('post', 'api/register', $payload)
            ->assertStatus(Response::HTTP_CREATED);

        $this->json('post', 'api/register', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'data' => [
                    'email',
                    'username',
                ],
               'success',
            ]);
    }

    public function test_user_can_register_and_login(): void
    {
        $payload = $this->getValidPaylod();
        
        $this->json('post', 'api/register', $payload)
            ->assertStatus(Response::HTTP_CREATED);

        $this->json('post', 'api/login', [
            'email' => $payload['email'],
            'password' => $payload['password'],
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'user' => [
                        'id',
                        'email',
                        'username',
                        'created_at',
                        'updated_at',
                    ],
                    'access_token',
                    'token_type'
                ],
                'success',
            ]);
    }

    public function test_user_can_not_login_using_incorrect_password(): void
    {
        $payload = $this->getValidPaylod();
        
        $this->json('post', 'api/register', $payload)
            ->assertStatus(Response::HTTP_CREATED);

        $this->json('post', 'api/login', [
            'email' => $payload['email'],
            'password' => 'not_the_password',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'data' => [
                    'error'
                ],
                'success',
            ]);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('post', 'api/logout')
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
