<?php

namespace App\Http\Requests\Ticket;
use App\Enums\EventStatus;
use App\Enums\TicketStatus;
use App\Http\Requests\ValidatedRequest;
use App\Http\Services\EventService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketCreateRequest extends ValidatedRequest
{
  public function prepareForValidation()
  {
    $this->merge([
      'user_id' => Auth::user()->getAuthIdentifier(),
      'event_id' => $this->event->id,
    ]);
  }

  public function rules()
  {
    $ticketStatus = array_map(fn($case) => $case->value, TicketStatus::cases());

    return [
      'user_id' => 'required|exists:users,id',
      'event_id' => 'required|exists:events,id',
      'status' => 'nullable|in:' . implode(",", $ticketStatus)
    ];  
  }

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      $event = EventService::getById($this->event->id);
      
      $today = Carbon::now();
      $deadline = $event->deadline;
      $eventDate = $event->date;

      $eventFinished = $event->status == EventStatus::Finished;
      $eventFull = $event->status == EventStatus::Full;
      $pastEventDeadline = $deadline && $today->gt($deadline);
      $pastEventDate = $today->greaterThan($eventDate);

      if ($event->tickets->where('id', Auth::user()->getAuthIdentifier())->count()) {
        $validator->errors()->add('user_id', 'User already registered for the event');
      }

      if ($event->tickets->count() >= $event->attendee_limit || $eventFull) {
        $validator->errors()->add('event_id', 'Event is full');
      }

      if ($pastEventDeadline || $pastEventDate || $eventFinished) {
        $validator->errors()->add('deadline', 'Event deadline has passed');
      }
    });
  }

  public function messages()
  {
    return [
      'user_id.required' => 'Authenticated user is required',
      'event_id.required' => 'Event is required',
    ];
  }
}