<?php

namespace App\Http\Requests\User;
use App\Http\Requests\ValidatedRequest;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends ValidatedRequest
{
  public function rules()
  {
    return [
      'email' => 'required|unique:users|email:rfc,dns|max:100',
      'username' => 'required|unique:users|max:50',
      'password'=> ['required', Password::min(8)->letters()->numbers()->uncompromised()],
    ];  
  }

  public function messages()
  {
    return [
      'email.required' => 'Email is required',
      'username.required' => 'Username is required',
      'password.required' => 'Password is required',
    ];
  }
}