<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Enums\TicketStatus;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TicketTest extends TestCase
{
    private function getValidEventPayload() {
        return [
            'title' => 'Event Title',
            'description' => 'Event Description',
            'deadline' => '2100-12-31 23:59:59',
            'date' => '2100-01-01 00:00:00',
            'location' => 'Event Location',
            'price' => 0,
            'attendee_limit' => 100,
            'status' => EventStatus::Pending,
        ];
    }

    private function getPastEventPayload() {
        return [
            'title' => 'Event Title',
            'description' => 'Event Description',
            'deadline' => '2021-12-31 23:59:59',
            'date' => '2021-01-01 00:00:00',
            'location' => 'Event Location',
            'price' => 0,
            'attendee_limit' => 100,
            'status' => EventStatus::Pending,
        ];
    }

    private function getFullEventPayload() {
        return [
            'title' => 'Event Title',
            'description' => 'Event Description',
            'deadline' => '2100-12-31 23:59:59',
            'date' => '2100-01-01 00:00:00',
            'location' => 'Event Location',
            'price' => 0,
            'attendee_limit' => 5,
            'status' => EventStatus::Pending,
        ];
    }

    private function getFinishedEventPayload() {
        return [
            'title' => 'Event Title',
            'description' => 'Event Description',
            'deadline' => '2100-12-31 23:59:59',
            'date' => '2100-01-01 00:00:00',
            'location' => 'Event Location',
            'price' => 0,
            'attendee_limit' => 5,
            'status' => EventStatus::Finished,
        ];
    }

    public function test_guest_can_not_view_tickets(): void
    {
        $this->json('get', 'api/tickets')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_can_view_tickets(): void {
        $user = User::factory()->create();

        $this->actingAs($user)->json('get', 'api/tickets')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'event_id',
                        'user_id',
                        'status',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'success'
            ]);
    }

    public function test_user_can_view_tickets_with_event_id(): void {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        
        Ticket::factory()->create([
            'user_id'=> $user->id,
            'event_id'=> $event->id,
        ]);

        $this->actingAs($user)->json('get','api/tickets/' . $event->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'event_id',
                    'user_id',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'success'
            ]);
    }

    public function test_user_can_create_tickets_for_valid_event(): void {
        $user = User::factory()->create();
        $event = Event::factory()->create($this->getValidEventPayload());

        $this->actingAs($user)->json('post','api/tickets/' . $event->id, [ 'status' => TicketStatus::Valid ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'event_id',
                    'user_id',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'success'
            ]);
    }

    public function test_user_can_update_its_own_tickets_for_valid_event(): void {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        
        Ticket::factory()->create([
            'user_id'=> $user->id,
            'event_id'=> $event->id,
        ]);

        $this->actingAs($user)->json('put','api/tickets/' . $event->id, [ 'status' => TicketStatus::Due ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'event_id',
                    'user_id',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'success'
            ]);
    }

    public function test_user_can_delete_its_own_tickets(): void {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        
        Ticket::factory()->create([
            'user_id'=> $user->id,
            'event_id'=> $event->id,
        ]);

        $this->actingAs($user)->json('delete','api/tickets/' . $event->id)
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_user_can_not_view_other_user_tickets(): void {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $event = Event::factory()->create();
        
        Ticket::factory()->create([
            'user_id'=> $anotherUser->id,
            'event_id'=> $event->id,
        ]);

        $this->actingAs($user)->json('get','api/tickets/' . $event->id)
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_can_not_create_tickets_for_past_events(): void {
        $user = User::factory()->create();
        $event = Event::factory()->create($this->getPastEventPayload());

        $this->actingAs($user)->json('post','api/tickets/' . $event->id, [ 'status' => TicketStatus::Valid ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'data' => [
                    'deadline',
                ],
                'success'
            ]);
    }

    public function test_user_can_not_create_tickets_for_finished_events(): void {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'status' => EventStatus::Finished
        ]);

        $this->actingAs($user)->json('post','api/tickets/' . $event->id, [ 'status' => TicketStatus::Valid ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'data' => [
                    'deadline',
                ],
                'success'
            ]);
    }

    public function test_user_can_not_create_tickets_for_full_events(): void {
        $user = User::factory()->create();
        $event = Event::factory()->create($this->getFullEventPayload());

        Ticket::factory(5)->create([
            'event_id'=> $event->id,
        ]);

        $this->actingAs($user)->json('post','api/tickets/' . $event->id, [ 'status' => TicketStatus::Valid ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'data' => [
                    'event_id',
                ],
                'success'
            ]);
    }
}
