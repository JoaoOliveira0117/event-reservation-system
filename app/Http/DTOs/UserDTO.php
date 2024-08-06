<?php

namespace App\Http\DTOs;

class UserDTO extends BaseDTO
{
  public string $username;
  public string $email;
  public string $password;

  public function __construct(array $data) {
    $this->username = $data['username'];
    $this->email = $data['email'];
    $this->password = $data['password'];
  }
}