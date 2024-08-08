<?php

namespace App\Http\Services;

use App\Http\DTOs\EventDTO;
use App\Models\Event;

class EventService extends Service {
  protected static string $model = Event::class;
  protected static string $DTO = EventDTO::class;

  public static function getUserEvents($user) {
    return $user->events;
  }

  public static function getEventTickets($event) {
    return $event->tickets;
  }

  public static function getAllEvents() {
    return self::$model::query()
      ->withUser()
      ->withBoughtTicketsCount()
      ->get();
  }

  public static function getEvent(string $eventId) {
    return self::$model::query()
      ->forEvent($eventId)
      ->withUser()
      ->withBoughtTicketsCount()
      ->firstOrFail();
  }
}