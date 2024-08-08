<?php

namespace App\Builders;
use Illuminate\Database\Eloquent\Builder;

class TicketBuilder extends Builder
{
  public function __construct($query)
  {
    parent::__construct($query);
  }

  public function forUser($id)
  {
    return $this->where('user_id', $id);
  }

  public function forEvent($id)
  {
    return $this->where('event_id', $id);
  }

  public function findOne(array $data) {
    return $this->forUser($data['user_id'])
      ->forEvent($data['event_id']);
  }

  public function withEvent() {
    return $this->with('event');
  }
}