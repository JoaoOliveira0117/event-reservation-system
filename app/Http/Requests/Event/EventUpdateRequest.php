<?php

namespace App\Http\Requests\Event;
use App\Enums\EventStatus;
use App\Http\Requests\ValidatedRequest;

class EventUpdateRequest extends ValidatedRequest
{
  public function rules(): array
  {
    $eventStatus = array_map(fn($case) => $case->value, EventStatus::cases());

    return [
        'title' => 'string|max:50',
        'description' => 'string|max:255',
        'deadline' => ['nullable', 'date', 
          function ($attribute, $value, $fail) {
            if ($value && $this->date && $value > $this->date) {
                $fail('The deadline must not be greater than the event date.');
            }
          }
        ],
        'date' => 'date',
        'location' => 'string|max:255',
        'price' => 'numeric|min:0',
        'attendee_limit' => 'nullable|integer|min:1',
        'status' => 'nullable|in:' . join($eventStatus, ','),
    ];
  }
}