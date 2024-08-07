<?php

namespace App\Http\Requests\Event;
use App\Enums\EventStatus;
use App\Http\Requests\ValidatedRequest;

class EventCreateRequest extends ValidatedRequest
{
  public function rules(): array
  {
    $eventStatus = array_map(fn($case) => $case->value, EventStatus::cases());

    return [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'deadline' => ['nullable', 'date', 
          function ($attribute, $value, $fail) {
            if ($value && $this->date && $value > $this->date) {
                $fail('The deadline must not be greater than the event date.');
            }
          }
        ],
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'attendee_limit' => 'nullable|integer|min:1',
        'status' => 'nullable|in:' . implode(",", $eventStatus)
    ];
  }
}