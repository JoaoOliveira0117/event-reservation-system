<?php

namespace App\Http\Requests\User;
use App\Http\Requests\ValidatedRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends ValidatedRequest
{
  public function rules()
  {
    return [
      'email' => ['unique:users', 'email:rfc,dns', 'max:100'],
      'username' => ['unique:users', 'max:50'],
      'password'=> [Password::min(8)->letters()->numbers()->uncompromised()],
    ];  
  }

  public function messages()
  {
    return [];
  }
}