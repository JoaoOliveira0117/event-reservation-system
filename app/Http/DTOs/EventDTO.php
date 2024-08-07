<?php

namespace App\Http\DTOs;

class EventDTO extends BaseDTO
{
  public string $title;
  public string $description;
  public string $deadline;
  public string $date;
  public string $location;
  public float $price;
  public int $attendee_limit;
  public ?string $status;
  public string $user_id;

  public function __construct(array $data)
  {
    $this->title = $data['title'];
    $this->description = $data['description'];
    $this->deadline = $data['deadline'];
    $this->date = $data['date'];
    $this->location = $data['location'];
    $this->price = $data['price'];
    $this->attendee_limit = $data['attendee_limit'];
    $this->status = $data['status'];
  }
}
