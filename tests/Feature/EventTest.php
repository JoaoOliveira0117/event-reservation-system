<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EventTest extends TestCase
{
    private function getValidPayload() {
        return [
            'title' => 'Event Title',
            'description' => 'Event Description',
            'deadline' => '2021-12-31 23:59:59',
            'date' => '2022-01-01 00:00:00',
            'location' => 'Event Location',
            'price' => 0,
            'attendee_limit' => 100,
            'status' => EventStatus::Pending,
        ];
    }

    private function getInvalidPayload() {
        return [
            'title' => 'Event Title',
            'description' => 'Event Description',

            // Deadline should not be greater than the event date
            'deadline' => '2024-12-31 23:59:59',
            'date' => '2000-01-01 00:00:00',
            'location' => 'Event Location',
            'price' => 0,

            // Attendee limit should be at least 1
            'attendee_limit' => 0,

            'status' => 'invalid_status',
        ];
    }

    public function test_guest_can_not_view_events(): void
    {
        $this->json('get', 'api/events')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_can_view_events(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('get', 'api/events')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'deadline',
                        'date',
                        'location',
                        'price',
                        'attendee_limit',
                        'status',
                        'created_at',
                        'updated_at',
                    ]
                ],
                'success',
            ]);
    }

    public function test_user_can_view_event_with_a_event_id(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->actingAs($user)->json('get', 'api/events/' . $event->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'deadline',
                    'date',
                    'location',
                    'price',
                    'attendee_limit',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'success',
            ]);
    }

    public function test_user_can_create_events(): void
    {
        $user = User::factory()->create();

        $payload = $this->getValidPayload();

        $this->actingAs($user)->json('post', 'api/events', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'deadline',
                    'date',
                    'location',
                    'price',
                    'attendee_limit',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'success',
            ]);
    }

    public function test_user_can_update_its_own_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $payload = $this->getValidPayload();

        $this->actingAs($user)->json('put', 'api/events/'. $event->id, $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'deadline',
                    'date',
                    'location',
                    'price',
                    'attendee_limit',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'success',
            ]);
    }

    public function test_user_can_delete_its_own_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->json('delete', 'api/events/'. $event->id)
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_user_can_not_create_invalid_events(): void
    {
        $user = User::factory()->create();

        $payload = $this->getInvalidPayload();

        $this->actingAs($user)->json('post', 'api/events', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'data' => [
                    'deadline',
                    'attendee_limit',
                    'status',
                ],
                'success',
            ]);
    }


    public function test_user_can_not_update_its_own_events_with_invalid_infos(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $payload = $this->getInvalidPayload();

        $this->actingAs($user)->json('put', 'api/events/'. $event->id, $payload)
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure([
            'data' => [
                'deadline',
                'attendee_limit',
                'status',
            ],
            'success',
        ]);
    }

    public function test_user_can_not_update_other_user_events(): void
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $event = Event::factory()->create(['user_id'=> $anotherUser->id]);

        $payload = $this->getValidPayload();

        $this->actingAs($user)->json('put', 'api/events/'. $event->id, $payload)
            ->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJsonStructure([
                'data' => [
                    'error'
                ],
                'success',
            ]);
    }

    public function test_user_can_not_delete_other_user_events(): void
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $anotherUser->id]);

        $this->actingAs($user)->json('delete', 'api/events/'. $event->id)
        ->assertStatus(Response::HTTP_FORBIDDEN)
        ->assertJsonStructure([
            'data' => [
                'error'
            ],
            'success',
        ]);
    }
}
