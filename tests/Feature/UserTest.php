<?php

namespace Tests\Feature;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    private function getValidPaylod() {
        return [
            'email'=> 'userexample@gmail.com',
            'username' => 'user_name',
            'password'=> '@@#@!@#SECUREPASSWORD123!@!@!@',
        ];
    }

    public function test_guest_can_not_view_users(): void
    {
        $this->json('get', 'api/users')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_can_view_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('get', 'api/users')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'email',
                        'username',
                        'created_at',
                        'updated_at',
                    ]
                ],
                'success',
            ]);
    }

    public function test_user_can_edit_itself(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('put', 'api/users/' . $user->id, $this->getValidPaylod())
            ->assertStatus(Response::HTTP_OK)
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

    public function test_user_can_delete_itself(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('delete','api/users/' . $user->id)
            ->assertStatus(Response::HTTP_NO_CONTENT);
        
        $this->json('get', 'api/users/' . $user->id)
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_can_not_edit_other_users(): void
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $this->actingAs($user)->json('put', 'api/users/' . $anotherUser->id, $this->getValidPaylod())
            ->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJsonStructure([
                'data' => [
                    'error',
                ],
                'success',
            ]);
    }

    public function test_user_can_not_delete_other_users(): void
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $this->actingAs($user)->json('delete','api/users/' . $anotherUser->id)
            ->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJsonStructure([
                'data' => [
                    'error',
                ],
                'success',
            ]);

        $this->json('get', 'api/users/' . $anotherUser->id)
            ->assertStatus(Response::HTTP_OK);
    }
}
