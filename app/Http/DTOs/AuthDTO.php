<?php

namespace App\Http\DTOs;

class AuthDTO extends BaseDTO
{
  public string $email;
  public string $password;

  public function __construct(array $data) {
    $this->email = $data['email'];
    $this->password = $data['password'];
  }
}