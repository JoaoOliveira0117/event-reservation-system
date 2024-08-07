<?php

namespace App\Http\Requests\Ticket;
use App\Enums\TicketStatus;
use App\Http\Requests\ValidatedRequest;
use Illuminate\Support\Facades\Auth;

class TicketUpdateRequest extends ValidatedRequest
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

  public function messages()
  {
    return [
      'user_id.required' => 'Authenticated user is required',
      'event_id.required' => 'Event is required',
    ];
  }
}