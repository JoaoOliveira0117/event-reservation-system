<?php

namespace App\Http\Services;

use App\Http\DTOs\TicketDTO;
use App\Models\Ticket;

class TicketService extends Service {
  protected static string $model = Ticket::class;
  protected static string $DTO = TicketDTO::class;

  public static function getTicket(array $data) {
    return self::$model::query()->findOne($data)->firstOrFail();
  }

  public static function getMyTickets(array $data) {
    return self::$model::query()->forUser($data['user_id'])->withEvent()->get();
  }
}