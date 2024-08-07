<?php

namespace App\Http\Services;

use App\Http\DTOs\TicketDTO;
use App\Models\Ticket;

class TicketService extends Service {
  protected static string $model = Ticket::class;
  protected static string $DTO = TicketDTO::class;
}