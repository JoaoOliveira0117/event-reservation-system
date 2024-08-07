<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\ValidatedRequest;
use Illuminate\Validation\Rules\Password;

class AuthLoginRequest extends ValidatedRequest
{
  public function rules()
  {
    return [
      'email' => 'required',
      'password'=> ['required', Password::min(8)],
    ];  
  }

  public function messages()
  {
    return [
      'email.required' => 'Email is required',
      'password.required' => 'Password is required',
    ];
  }
}