<?php

namespace App\Http\Services;

use App\Http\DTOs\EventDTO;
use App\Models\Event;

class EventService extends Service {
  protected static string $model = Event::class;
  protected static string $DTO = EventDTO::class;

  public static function getAllEvents() {
    return self::$model::query()
      ->withUser()
      ->withBoughtTicketsCount()
      ->sortByCreatedAt()
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