<?php

namespace App\Builders;
use Illuminate\Database\Eloquent\Builder;

class EventBuilder extends Builder
{
  public function __construct($query)
  {
    parent::__construct($query);
  }

  public function forEvent($id)
  {
    return $this->where('id', $id);
  }

  public function withUser()
  {
    return $this->with(['createdBy' => function ($q) {
      $q->select('id', 'username');
    }]);
  }

  public function withBoughtTicketsCount()
  {
    return $this->withCount('tickets');
  }

  public function sortByCreatedAt()
  {
    return $this->orderBy('created_at','desc');
  }
}