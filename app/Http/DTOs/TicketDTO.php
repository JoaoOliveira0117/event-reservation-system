<?php

namespace App\Http\DTOs;

class TicketDTO extends BaseDTO
{
  public string $user_id;
  public string $event_id;
  public ?string $status;

  public function __construct(array $data) {
    $this->user_id = $data['user_id'];
    $this->event_id = $data['event_id'];
    $this->status = $data['status'] ?? null;
  }
}