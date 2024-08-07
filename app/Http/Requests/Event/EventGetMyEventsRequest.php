<?php

namespace App\Http\Requests\Event;
use App\Http\Requests\ValidatedRequest;
use Illuminate\Support\Facades\Auth;

class EventGetMyEventsRequest extends ValidatedRequest
{
  public function prepareForValidation()
  {
    $this->merge([
      'user_id' => Auth::user()->getAuthIdentifier(),
    ]);
  }

  public function rules(): array
  {
    return [
        'user_id' => 'required|exists:users,id'
    ];
  }
}