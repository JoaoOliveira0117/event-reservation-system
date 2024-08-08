<?php

namespace App\Builders;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
  public function __construct($query)
  {
    parent::__construct($query);
  }

  public function forUser($id)
  {
    return $this->where('id', $id);
  }

  public function withEvents()
  {
    return $this->with('events');
  }

  public function withTickets()
  {
    return $this->with(['tickets' => function ($q) {
      $q->select('id as event_id', 'title' , 'tickets.created_at');
    }]);
  }
}